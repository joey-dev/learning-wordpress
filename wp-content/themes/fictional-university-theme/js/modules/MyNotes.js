import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $("#my-notes").on('click', '.delete-note', this.deleteNote);
        $("#my-notes").on('click', ".edit-note", this.editNote.bind(this));
        $("#my-notes").on('click', ".update-note", this.updateNote.bind(this));
        $(".submit-note").on('click', this.submitNote.bind(this));
    }

    deleteNote(event) {
        const urlWithoutUrl = universityData.root_url + '/wp-json/wp/v2/note/';
        const thisNote = $(event.target).parents("li");

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: urlWithoutUrl + thisNote.data('id'),
            type: 'DELETE',
            success: (response) => {
                thisNote.slideUp();

                if (response.userNoteCount < 5) {
                    $(".note-limit-message").removeClass('active');
                }
                console.log('success');
                console.log(response);
            },
            error: (response) => {
                console.log('error');
                console.log(response);
            },
        })
    }

    editNote(event) {
        const thisNote = $(event.target).parents("li");

        if (thisNote.data('state') === 'editable') {
            this.makeNoteReadOnly(thisNote);
        } else {
            this.makeNoteEditable(thisNote);
        }
    }

    makeNoteEditable(thisNote) {
        thisNote.find('.edit-note').html('<i class="fa fa-times"></i> Cancel');
        thisNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
        thisNote.find('.update-note').addClass('update-note--visible');

        thisNote.data('state', 'editable');
    }

    makeNoteReadOnly(thisNote) {
        thisNote.find('.edit-note').html('<i class="fa fa-pencil"></i> Edit');
        thisNote.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass('note-active-field');
        thisNote.find('.update-note').removeClass('update-note--visible');

        thisNote.data('state', 'cancel');
    }

    updateNote(event) {
        const urlWithoutUrl = universityData.root_url + '/wp-json/wp/v2/note/';
        const thisNote = $(event.target).parents("li");

        const updatedPost = {
            title: thisNote.find('.note-title-field').val(),
            content: thisNote.find('.note-body-field').val()
        };

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: urlWithoutUrl + thisNote.data('id'),
            type: 'POST',
            data: updatedPost,
            success: (response) => {
                this.makeNoteReadOnly(thisNote);
                console.log('success');
                console.log(response);
            },
            error: (response) => {
                console.log('error');
                console.log(response);
            },
        })
    }

    submitNote(event) {
        const urlWithoutUrl = universityData.root_url + '/wp-json/wp/v2/note/';

        const newPost = {
            title: $('.new-note-title').val(),
            content: $('.new-note-body').val(),
            status: 'private',
        };

        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce)
            },
            url: urlWithoutUrl,
            type: 'POST',
            data: newPost,
            success: (response) => {
                $('.new-note-title, .new-note-body').val('');
                $(`
                    <li data-id="${response.id}">
                        <input type="text" value="${response.title.raw}" class="note-title-field" readonly>
                        <span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o"></i> Delete</span>
                        <textarea readonly class="note-body-field">${response.content.raw}</textarea>
    
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i> Save</span>
                    </li>
                `).prependTo("#my-notes").hide().slideDown();
                console.log('success');
                console.log(response);
            },
            error: (response) => {
                if (response.responseText === "note limit") {
                    $(".note-limit-message").addClass('active');
                }
                console.log('error');
                console.log(response);
            },
        })
    }
}

export default MyNotes;
