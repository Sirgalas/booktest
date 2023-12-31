<?php

namespace app\Entities\User\Entity;

use app\Entities\Author\Entity\Author;
use app\Entities\User\Entity\Auth\AuthAssignment;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Author[] $authors
 * @property UserAuthor[] $userAuthors
 * @property AuthAssignment $authAssignment
 * @property UserMessage[] $messages
 * @property UserMessage[] $messagesView
 *
 */

class User  extends ActiveRecord implements \yii\web\IdentityInterface
{
    public const ADMIN = 'admin';
    public const USER = 'user';
    public const GUEST = 'guest';

    public static $roles = [
        self::USER => self::USER,
        self::GUEST => self::GUEST
    ];

    public function behaviors(): array
    {
        return [
            [
                'class'     => SaveRelationsBehavior::class,
                'relations' => ['authors'],
            ],
        ];
    }

    public static function create(string $username, string $email, string $password,string $phone): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->phone = $phone;
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->created_at = time();
        $user->updated_at = time();
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    public static function requestSignup(string $username, string $email, string $password): self
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->created_at = time();
        $user->generateAuthKey();
        return $user;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|null
     */
    public static function findByUsername(string $username)
    {
        return User::find()->where(['or',['email' => $username],['username' => $username]])->one();
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


    private function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    private function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(UserMessage::class,['user_id' => 'id']);
    }

    public function getMessagesView(): ActiveQuery
    {
        return $this->getMessages()->where(['is_view' => 0]);
    }

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('userAuthors');
    }

    public function getUserAuthors(): ActiveQuery
    {
        return $this->hasMany(UserAuthor::class, ['user_id' => 'id']);
    }

    public function getAuthAssignment(): ActiveQuery
    {
        return $this->hasOne(AuthAssignment::class,['user_id' => 'id']);
    }

    public function addAuthors(Author $author): void
    {
        $authors = $this->authors;
        foreach ($authors as $oneAuthor) {
            if($oneAuthor->isHasAuthor($author->id)) {
                return;
            }
        }
        $authors[] = $author;
        $this->authors = $authors;
    }

    public function removeAuthor(int $id) {
        $authors = $this->authors;
        foreach ($authors as  $key => $author) {
            if($author->isHasAuthor($id)) {
                unset($authors[$key]);
            }
        }
        $this->authors = $authors;
    }

}
