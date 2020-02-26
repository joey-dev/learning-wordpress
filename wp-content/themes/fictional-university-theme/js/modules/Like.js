import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on('click', this.courClickDispatcher.bind(this))
    }

    courClickDispatcher(event) {
        const currentLikeBox = $(event.target).closest('.like-box');

        if (currentLikeBox.attr('data-exists') === 'yes') {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }

    createLike(currentLikeBox) {
        const urlWithoutId = universityData.root_url + '/wp-json/university/v1/manageLike';
        const professorId = currentLikeBox.attr('data-professor');

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: urlWithoutId,
            type: 'POST',
            data: {
                professorId: professorId,
            },
            success: (response) => {
                currentLikeBox.attr('data-exists', 'yes');
                const likeCount = currentLikeBox.find('.like-count').html();
                const likeCountAsInt = parseInt(likeCount);

                currentLikeBox.find('.like-count').html(likeCountAsInt + 1);

                currentLikeBox.attr('data-like', response);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            },
        });
    }

    deleteLike(currentLikeBox) {
        const urlWithoutId = universityData.root_url + '/wp-json/university/v1/manageLike';
        const likeId = currentLikeBox.attr('data-like');

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: urlWithoutId,
            type: 'DELETE',
            data: {
                like: likeId,
            },
            success: (response) => {
                currentLikeBox.attr('data-exists', 'no');
                const likeCount = currentLikeBox.find('.like-count').html();
                const likeCountAsInt = parseInt(likeCount);

                currentLikeBox.find('.like-count').html(likeCountAsInt - 1);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            },
        });
    }

}

export default Like;
