<?php
$title = '';
$metaDescription = '';

if (isset($thread)) {
    $title = $thread->title . ' -';
    $metaDescription = str_limit(strip_tags(Markdown::convertToHtml($thread->firstPost->content)), 80, '...');
} elseif (isset($category)) {
    $title = $category->title . ' -';
    $metaDescription = $category->description;
}
?>

@extends('layouts.v2.banner', [
    'page' => [
        'title' => $title . ' Forum',
        'class' => 'forum',
        'description' => $metaDescription
    ],
    'banner' => [
        'text-only' => true,
        'size' => 'small',
        'vertical-align' => true
    ]
])

@section('page_content')

    <div class="container forum_wrapper">
        <div class="row">

            <div class="col-md-10 center-block">

                @include ('forum::partials.breadcrumbs')

                @yield('content')
            </div>
        </div>


    </div>
@stop

@section('footer_scripts')
    <script>
        var toggle = $('input[type=checkbox][data-toggle-all]');
        var checkboxes = $('table tbody input[type=checkbox]');
        var actions = $('[data-actions]');
        var forms = $('[data-actions-form]');
        var confirmString = "{{ trans('forum::general.generic_confirm') }}";

        function setToggleStates() {
            checkboxes.prop('checked', toggle.is(':checked')).change();
        }

        function setSelectionStates() {
            checkboxes.each(function () {
                var tr = $(this).parents('tr');

                $(this).is(':checked') ? tr.addClass('active') : tr.removeClass('active');

                checkboxes.filter(':checked').length ? $('[data-bulk-actions]').removeClass('hidden') : $('[data-bulk-actions]').addClass('hidden');
            });
        }

        function setActionStates() {
            forms.each(function () {
                var form = $(this);
                var method = form.find('input[name=_method]');
                var selected = form.find('select[name=action] option:selected');
                var depends = form.find('[data-depends]');

                selected.each(function () {
                    if ($(this).attr('data-method')) {
                        method.val($(this).data('method'));
                    } else {
                        method.val('patch');
                    }
                });

                depends.each(function () {
                    (selected.val() == $(this).data('depends')) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
                });
            });
        }

        setToggleStates();
        setSelectionStates();
        setActionStates();

        toggle.click(setToggleStates);
        checkboxes.change(setSelectionStates);
        actions.change(setActionStates);

        forms.submit(function () {
            var action = $(this).find('[data-actions]').find(':selected');

            if (action.is('[data-confirm]')) {
                return confirm(confirmString);
            }

            return true;
        });

        $('form[data-confirm]').submit(function () {
            return confirm(confirmString);
        });

        if ($('.alert-autohide:not(.alert-danger)').length) {
            $('.alert-autohide').fadeTo(2000, 500).slideUp(500, function () {
                $('.alert-autohide').alert('close');
            });
        }

    </script>
@stop
