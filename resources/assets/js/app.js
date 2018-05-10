
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// TODO: translation on js side

// TODO: use function to show/hide alert

(() => {
    'use strict';

    let submit = $('#button-submit');
    let clear = $('#button-clear');
    let urlInput = $('#input-url');
    let aliasInput = $('#input-alias');
    let alert = $('#alert')
    let toggleOptions = $('#button-toggle-options');
    let toggleApi= $('#button-toggle-api');
    let optionsSection = $('#options');
    let apiSection = $('#api');

    let isSubmitted = false;

    urlInput.on('keyup paste', () => {
        let pattern = new RegExp('^(https?:\\/\\/)?' +
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' +
            '((\\d{1,3}\\.){3}\\d{1,3}))' +
            '(\\:\\d+)?' +
            '(\\/[-a-z\\d%@_.~+&:]*)*' +
            '(\\?[;&a-z\\d%@_.,~+&:=-]*)?' +
            '(\\#[-a-z\\d_]*)?$','i');
        let isUrlValid = pattern.test(urlInput.val());

        submit.attr('disabled', !isUrlValid);
        clear.toggle(!!urlInput.val().length);

        if (isUrlValid) {
            urlInput.removeClass('is-invalid').addClass('is-valid');
        } else {
            urlInput.removeClass('is-valid').addClass('is-invalid');
        }
    });

    clear.click(() => {
        isSubmitted = false;
        urlInput.attr('readonly', false).val('');
        clear.hide();
        alert.hide();

        submit.attr('disabled', true).text('Shorten');
    });

    submit.click(() => {
        if (isSubmitted)
        {
            try {
                if (document.execCommand('copy')) {
                    alert
                        .addClass('alert-success').removeClass('alert-danger')
                        .html('Shortened url has been copied to the clipboard!')
                        .show();

                    return false;
                }
            } catch (err) {
                console.log('Unsupported Browser!');
                // TODO: add support of old browsers if required
            }

            alert
                .addClass('alert-danger').removeClass('alert-success')
                .html('Can\'t copy shortened url to the clipboard :(')
                .show();

            return false;
        }

        // TODO: set base url explicitly
        $.post('api/v1/shorten', {url: urlInput.val(), alias: aliasInput.val()})
            .done(response => {
                if (response.full_alias)
                {
                    isSubmitted = true;
                    urlInput.attr('readonly', true).val(response.full_alias).select();
                    submit.text('Copy');
                    alert
                        .addClass('alert-success').removeClass('alert-danger')
                        .html('Url "' + response.url + '" has been shortened!<br>' +
                            'Now you can copy it.<br>' +
                            'Url statatistics on <a href="' + response.statistics_url + '" target="_blank">' + response.statistics_url + '</a>'
                        )
                        .show();
                }
            })
            .fail(response => {
                let messages = response.responseJSON.errors;

                alert
                    .addClass('alert-danger').removeClass('alert-success')
                    .html(Object.values(messages).join('<br>'))
                    .show();
            });

        return false;
    });

    toggleOptions.click(() => optionsSection.toggle(100));
    toggleApi.click(() => {
        apiSection.toggle(100);

        if (apiSection.is(':visible'))
        {
            $('html, body').animate({scrollTop: apiSection.offset().top}, 300);
        }

        return false;
    });

    $(document).ajaxStart(() => NProgress.start());
    $(document).ajaxStop(() => NProgress.done());
})();



