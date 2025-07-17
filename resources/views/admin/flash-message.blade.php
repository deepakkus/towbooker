

@if(session()->has('success'))
<div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i></div>
        <div class="ms-3">
            <div class="text-success">{{ session()->get('success') }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('error'))
<div class="alert border-0 bg-light-danger alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="fs-3 text-danger"><i class="bi bi-x-circle-fill"></i></div>
        <div class="ms-3">
            <div class="text-danger">{{ session()->get('error') }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('warning'))
<div class="alert border-0 bg-light-warning alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="fs-3 text-warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div class="ms-3">
            <div class="text-warning">{{ session()->get('warning') }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('info'))
<div class="alert border-0 bg-light-info alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="fs-3 text-info"><i class="bi bi-info-circle-fill"></i></div>
        <div class="ms-3">
            <div class="text-info">{{ session()->get('info') }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert border-0 bg-light-dark alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="fs-3 text-dark"><i class="bi bi-bell-fill"></i></div>
        <div class="ms-3">
            <div class="text-dark">Please check the form below for errors</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
