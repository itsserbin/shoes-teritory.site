@extends('layouts.app')
@section('title','Карточка клиента')
@section('header','Карточка клиента')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('clients.edit') }}
        <hr>
        <div class="row">
            <div class="col-12">
                <edit-client
                    new-status="{{\App\Models\Enum\ClientStatus::NEW_STATUS}}"
                    experienced-status="{{\App\Models\Enum\ClientStatus::EXPERIENCED_STATUS}}"
                    return-status="{{\App\Models\Enum\ClientStatus::RETURN_STATUS}}"
                    top-status="{{\App\Models\Enum\ClientStatus::TOP_STATUS}}"
                    black-list-status="{{\App\Models\Enum\ClientStatus::BLACK_LIST_STATUS}}"

                    experienced-status-satisfied="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_SATISFIED}}"
                    experienced-status-asked-for-an-exchange="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_ASKED_FOR_AN_EXCHANGE}}"
                    experienced-status-no-response="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_NO_RESPONSE}}"
                    experienced-status-not-satisfied="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_NOT_SATISFIED}}"
                    experienced-status-in-progress="{{\App\Models\Enum\ClientSubStatus::EXPERIENCED_STATUS_IN_PROGRESS}}"
                    return-status-agreed="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_AGREED}}"
                    return-status-refused="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_REFUSED}}"
                    return-status-didnt-get-in-touch="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_DIDNT_GET_IN_TOUCH}}"
                    return-status-new="{{\App\Models\Enum\ClientSubStatus::RETURN_STATUS_NEW}}"
                ></edit-client>
            </div>
        </div>
    </div>
@endsection
