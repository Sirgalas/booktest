<?php

namespace app\Entities\Book\Entity;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\Entities\Book\Entity\Book;

/**
 * BookSearch represents the model behind the search form of `app\Entities\Book\Entity\Book`.
 */
class BookSearch extends Book
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_id'], 'integer'],
            [['title', 'year', 'description'], 'safe'],
            [['isbn'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Book::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'isbn' => $this->isbn,
            'file_id' => $this->file_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
