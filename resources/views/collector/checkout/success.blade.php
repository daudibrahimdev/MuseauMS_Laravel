@extends('layouts.collector')

@section('title', 'Acquisition Requested | MuseauMS')

@section('content')
<div style="padding: 10rem 7% 5rem; min-height: 100vh; background-color: var(--bg); color: #fff; text-align: center; font-family: 'Poppins', sans-serif;">
    
    <div style="margin-bottom: 3rem;">
        <i data-feather="check-circle" style="width: 80px; height: 80px; color: var(--primary);"></i>
    </div>

    <h1 style="font-size: 3rem; font-weight: 800; letter-spacing: -2px; text-transform: uppercase; margin-bottom: 1rem;">
        Acquisition <span>Requested.</span>
    </h1>
    
    <p style="color: #888; font-size: 1.2rem; max-width: 700px; margin: 0 auto 3rem;">
        Your request to acquire these masterpieces has been recorded. To secure your portfolio, please complete the bank transfer within 24 hours.
    </p>

    {{-- PREMIUM ALERT SECTION --}}
    <div style="max-width: 1000px; margin: 0 auto;">
        @if(session('success'))
            <div style="background: rgba(46, 204, 113, 0.1); border: 1px solid #2ecc71; color: #2ecc71; padding: 1.5rem; margin-bottom: 3rem; text-align: center; border-radius: 4px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
                <i data-feather="shield" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 10px;"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: rgba(231, 76, 60, 0.1); border: 1px solid #e74c3c; color: #e74c3c; padding: 1.5rem; margin-bottom: 3rem; text-align: center; border-radius: 4px; text-transform: uppercase; letter-spacing: 1px;">
                @foreach ($errors->all() as $error)
                    <p style="margin: 0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; max-width: 1000px; margin: 0 auto; text-align: left;">
        
        {{-- Gallery Treasury Details --}}
        <div style="background: #0a0a0a; padding: 3rem; border: 1px solid #1a1a1a;">
            <h2 style="font-size: 1.2rem; text-transform: uppercase; letter-spacing: 2px; color: var(--primary); margin-bottom: 2.5rem; border-bottom: 1px solid #222; padding-bottom: 1rem;">
                Gallery Treasury
            </h2>
            <div style="display: flex; flex-direction: column; gap: 2rem; color: #ccc;">
                <div>
                    <label style="display: block; font-size: 0.7rem; color: #444; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Bank Name</label>
                    <span style="font-size: 1.2rem; font-weight: 600;">Museau Private Bank</span>
                </div>
                <div>
                    <label style="display: block; font-size: 0.7rem; color: #444; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Account Number</label>
                    <span style="font-size: 1.5rem; font-weight: 700; letter-spacing: 3px; color: #fff;">9900 1234 5678 90</span>
                </div>
                <div>
                    <label style="display: block; font-size: 0.7rem; color: #444; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">Beneficiary</label>
                    <span style="font-size: 1.2rem; font-weight: 600;">MuseauMS Gallery Indonesia</span>
                </div>
            </div>
        </div>

        {{-- Payment Proof Upload Area --}}
        <div style="background: #0a0a0a; padding: 3rem; border: 1px solid #1a1a1a;">
            <h2 style="font-size: 1.2rem; text-transform: uppercase; letter-spacing: 2px; color: var(--primary); margin-bottom: 2.5rem; border-bottom: 1px solid #222; padding-bottom: 1rem;">
                Submit Proof
            </h2>
            <form action="{{ route('collector.orders.upload-proof', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-size: 0.75rem; color: #444; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">Transaction Slip Acquisition</label>
                    
                    {{-- Custom Luxury Upload Zone --}}
                    <div style="position: relative; width: 100%;">
                        <input type="file" name="payment_proof" id="payment_proof" required
                            style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;"
                            onchange="document.getElementById('file-label').innerText = this.files[0].name.toUpperCase()">
                        
                        <div style="width: 100%; padding: 3.5rem 1rem; border: 2px dashed #222; text-align: center; background: #000; border-radius: 4px; transition: 0.4s;" id="upload-zone">
                            <i data-feather="upload-cloud" style="width: 32px; height: 32px; color: #333; margin-bottom: 1rem;"></i>
                            <p id="file-label" style="color: #666; font-size: 0.85rem; margin: 0; text-transform: uppercase; letter-spacing: 2px; font-weight: 500;">
                                Select Acquisition Receipt
                            </p>
                            <p style="color: #333; font-size: 0.65rem; margin-top: 0.8rem; letter-spacing: 1px;">SUPPORTED: JPG, PNG, OR PDF (MAX. 2MB)</p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="cta" style="width: 100%; border: none; padding: 1.3rem; cursor: pointer; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; transition: 0.3s;"
                        onmouseover="this.style.backgroundColor='#966e48'" onmouseout="this.style.backgroundColor='var(--primary)'">
                    Finalize Submission
                </button>
            </form>
        </div>
    </div>

    <div style="margin-top: 6rem;">
        <a href="{{ route('collector.home') }}" style="color: #444; text-decoration: none; border-bottom: 1px solid #222; padding-bottom: 5px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 2px; transition: 0.3s;" onmouseover="this.style.color='var(--primary)'; this.style.borderColor='var(--primary)'">
            Return to Private Gallery
        </a>
    </div>
</div>

{{-- Dynamic Visual Feedback Script --}}
<script>
    const zone = document.getElementById('upload-zone');
    const input = document.getElementById('payment_proof');

    input.addEventListener('mouseenter', () => {
        zone.style.borderColor = 'var(--primary)';
        zone.style.background = 'rgba(182, 137, 91, 0.03)';
    });

    input.addEventListener('mouseleave', () => {
        zone.style.borderColor = '#222';
        zone.style.background = '#000';
    });
</script>
@endsection