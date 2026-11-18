@php $uid = $uid ?? 'faq'; @endphp
<div class="accordion faq" id="{{ $uid }}" data-stagger>
    @foreach ($items as $i => $f)
        <div class="accordion-item" data-reveal-item>
            <h3 class="accordion-header">
                <button class="accordion-button {{ $i === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $uid }}-{{ $i }}" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" aria-controls="{{ $uid }}-{{ $i }}">
                    {{ $f[0] }}
                </button>
            </h3>
            <div id="{{ $uid }}-{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#{{ $uid }}">
                <div class="accordion-body">{{ $f[1] }}</div>
            </div>
        </div>
    @endforeach
</div>
