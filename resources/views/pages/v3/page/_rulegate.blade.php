<?php
  use GameserverApp\Models\Page;
?>

    @isset($top)
        <div class="rulegate">
            <div class="container rulegate-form-alert">
                <div class="row">
                    <div class="col-md-8 center-block text-center">
                        <div class="alert alert-warning">
                            Please scroll down to accept the rules.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

    @isset($bottom)
        <div class="rulegate bg">
            <div class="container rulegate-form">
                <div class="row">
                    <div class="col-md-8 center-block text-center">

                        <form method="post" action="{{route('user.accept_rules', ['access_group_id' => Page::ruleGateAccessGroupId()])}}">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-theme btn-theme-basic accept-rules">
                                <span>Yes, I understand and will respect the rules!</span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endisset
