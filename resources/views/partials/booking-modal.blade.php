<div class="modal fade booking-modal" id="bookingModal" tabindex="-1" aria-labelledby="bookingTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <button type="button" class="icon-btn modal-x" data-bs-dismiss="modal" aria-label="Close"><x-icon name="x" :size="20" /></button>
            <div class="modal-body">
                <div class="booking-head">
                    <span class="eyebrow">Free consultation</span>
                    <h2 id="bookingTitle">Let’s talk about <span class="accent">your</span> project</h2>
                    <p>Fill this in and we'll continue on WhatsApp — scope and price within 24 hours.</p>
                </div>
                @include('partials.booking-form', ['fid' => 'bm'])
            </div>
        </div>
    </div>
</div>
