<!-- Blade view for get_carousel. Silakan gunakan controller untuk logic dan kirim data ke sini. -->
@if(isset($carousel) && count($carousel) > 0)
    <ul>
        @foreach($carousel as $item)
            <li>
                <strong>{{ $item['title'] }}</strong><br>
                <img src="{{ asset($item['image_path']) }}" alt="{{ $item['title'] }}" width="200">
                <p>{{ $item['subtitle'] }}</p>
                <span>{{ $item['button_text'] }}</span>
            </li>
        @endforeach
    </ul>
@else
    <p>Tidak ada data carousel.</p>
@endif
