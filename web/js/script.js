const deleteAuthorMessage = document.querySelector('.message-author-delete');
deleteAuthorMessage.addEventListener("click",(event) => {
    let messageId = event.target.parentNode.getAttribute('data-id');
    let parrent = event.target.parentNode.parentNode;
     fetch('/message/visible?id=' + messageId,{method: "POST"})
        .then(request => {
            console.log(request);
            parrent.remove();
        });
})
