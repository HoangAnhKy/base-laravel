<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body text-center py-4 {{ $class_bg ?? "" }} text-white">
        <p class="fs-5 mb-2">
            <i class="{{ $class_icon ?? "" }}"></i>
            <span class="fw-semibold">{{ $title ?? "title" }}</span>
        </p>
        <p class="fw-bold display-4 mb-0">{{ $total ?? 0 }}</p>
    </div>
</div>
