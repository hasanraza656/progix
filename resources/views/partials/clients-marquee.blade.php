{{-- Two counter-moving rows, five colour logos each (as requested by client) --}}
@php $rows = array_chunk($site['clients'], 5); @endphp
<div class="marquee-wrap" role="group" aria-label="Companies we have worked with">
    @foreach ($rows as $i => $row)
        <div class="marquee {{ $i % 2 ? 'marquee--rev' : '' }}">
            <ul class="marquee-track">
                {{-- Track = 2 identical halves (translate -50% loops seamlessly); each half repeats the 5 logos 3x to cover ultra-wide screens --}}
                @for ($half = 0; $half < 2; $half++)
                    @for ($rep = 0; $rep < 3; $rep++)
                        @foreach ($row as $cl)
                            @php $first = ($half === 0 && $rep === 0); @endphp
                            <li class="logo-chip" @unless($first) aria-hidden="true" @endunless>
                                <img src="{{ asset('assets/img/clients/'.$cl['file'].'.webp') }}" width="{{ $cl['w'] }}" height="{{ $cl['h'] }}" style="--ar:{{ round($cl['w'] / $cl['h'], 2) }}" alt="{{ $first ? $cl['name'].' logo' : '' }}" loading="lazy" decoding="async">
                            </li>
                        @endforeach
                    @endfor
                @endfor
            </ul>
        </div>
    @endforeach
</div>
