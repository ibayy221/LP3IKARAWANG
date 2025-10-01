@if(isset($carousel) && count($carousel) > 0)
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($carousel as $index => $item)
                <div class="carousel-item @if($index == 0) active @endif">
                    <img src="{{ asset($item['image_path']) }}" class="d-block w-100" alt="{{ $item['title'] }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $item['title'] }}</h5>
                        <p>{{ $item['subtitle'] }}</p>
                        @if(!empty($item['button_text']))
                            <a href="#" class="btn btn-primary">{{ $item['button_text'] }}</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@else
    <p>Tidak ada data carousel.</p>
@endif
