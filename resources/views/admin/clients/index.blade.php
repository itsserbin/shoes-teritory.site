@extends('layouts.app')
@section('title', 'Клиенты')
@section('header', 'Клиенты')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('clients') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <clients-list
                    new-status="{{\App\Models\Enum\ClientStatus::NEW_STATUS}}"
                    experienced-status="{{\App\Models\Enum\ClientStatus::EXPERIENCED_STATUS}}"
                    return-status="{{\App\Models\Enum\ClientStatus::RETURN_STATUS}}"
                    top-status="{{\App\Models\Enum\ClientStatus::TOP_STATUS}}"
                    black-list-status="{{\App\Models\Enum\ClientStatus::BLACK_LIST_STATUS}}"
                    destroy-mass-action="{{\App\Models\Enum\MassActions::DESTROY}}"

                    experienced-status-satisfied="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_SATISFIED}}"
                    experienced-status-asked-for-an-exchange="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_ASKED_FOR_AN_EXCHANGE}}"
                    experienced-status-no-response="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_NO_RESPONSE}}"
                    experienced-status-not-satisfied="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_NOT_SATISFIED}}"
                    experienced-status-in-progress="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_IN_PROGRESS}}"
                    return-status-agreed="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_AGREED}}"
                    return-status-refused="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_REFUSED}}"
                    return-status-didnt-get-in-touch="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_DIDNT_GET_IN_TOUCH}}"
                    return-status-new="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_NEW}}"

                    administrator-role="{{json_encode(auth()->check() && auth()->user()->hasRole('administrator'))}}"
                    manager-role="{{json_encode(auth()->check() && auth()->user()->hasRole('manager'))}}"
                    admin-permission="{{json_encode(Gate::allows('admin'))}}"
                    show-clients-permission="{{json_encode(Gate::allows('show-clients'))}}"
                    delete-clients-permission="{{json_encode(Gate::allows('delete-clients'))}}"
                ></clients-list>
            </div>
        </div>
    </div>
@endsection
