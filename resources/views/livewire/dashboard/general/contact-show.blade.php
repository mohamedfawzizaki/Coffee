<div class="main-content app-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Support')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Support')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="col-xl-9">

                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title">التواصل</div>

                    </div>

                    <div class="card-body">
                        <h5 class="fw-semibold mb-4 task-title">
                            {{ $contact->title }}
                        </h5>
                        <div class="fs-15 fw-semibold mb-2">الوصف :</div>
                        <p class="text-muted task-description">
                            {{ $contact->message }}
                        </p>
                    </div>

                    <div class="card-footer">

                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">

                            <div>
                                <span class="d-block text-muted fs-12">تمت رؤيته من قبل</span>
                                <div class="d-flex align-items-center">
                                    <div class="me-2 lh-1">
                                        <span class="avatar avatar-xs avatar-rounded">
                                            <img src="{{ $contact->admin?->image }}" alt="">
                                        </span>
                                    </div>
                                    <span class="d-block fs-14 fw-semibold">
                                        {{ $contact->admin?->name }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <span class="d-block text-muted fs-12">تاريخ الانشاء</span>
                                <span class="d-block fs-14 fw-semibold">
                                    {{ $contact->created_at->format('d,M Y') }}
                                </span>
                            </div>

                            <div>
                                <span class="d-block text-muted fs-12">تاريخ اخر تحديث</span>
                                <span class="d-block fs-14 fw-semibold">
                                     {{ $contact->updated_at->format('d,M Y') }}
                                </span>
                            </div>

                           
                            {{--  <div>
                                <span class="d-block text-muted fs-12">Efforts</span>
                                <span class="d-block fs-14 fw-semibold">45H : 35M : 45S</span>
                            </div>  --}}
                        </div>
                    </div>
                </div>

                <!--
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">الردود</div>
                    </div>
                    <div class="card-body">
                         <div class="alert alert-warning">ميزة الردود قيد التطوير</div>
                    </div>
                </div>
                -->

                    <div class="card-footer">
                        <div class="d-sm-flex align-items-center lh-1">

                            <div class="flex-fill me-sm-2">

                                <form wire:submit="sendMessage">

                                    <div class="input-group">

                                        <input type="text" class="form-control" placeholder="اكتب الرد" wire:model="newMessage">

                                        <button class="btn btn-primary btn-wave waves-effect waves-light" type="submit">ارسال الرد</button>

                                    </div>

                                @error('newMessage')

                                 <span class="text-danger">{{ $message }}</span>

                               @enderror

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-3">

                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                          معلومات العميل
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                    <tr>
                                        <td><span class="fw-semibold">الاسم :</span></td>
                                        <td>{{ $contact->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-semibold">البريد الالكتروني :</span></td>
                                        <td>{{ $contact->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-semibold">رقم الهاتف :</span></td>
                                        <td>{{ $contact->customer->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="fw-semibold">عنوان المشكلة :</span></td>
                                        <td>{{ $contact->title }}</td>
                                    </tr>

                                    <tr>
                                        <td><span class="fw-semibold">تاريخ الانشاء :</span></td>
                                        <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('dashboard.customer.show', $contact->customer->id) }}" class="btn btn-primary d-block">عرض الملف الشخصي</a>
                    </div>
                </div>



            </div>
        </div>

    </div>
</div>
