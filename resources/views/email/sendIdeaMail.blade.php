@foreach ($ideas as $index => $idea)
    <p>{{$index+1}}: <a style="text-decoration: none" href="{{ route('dashboard.idea.show', $idea->uuid) }}">{{$idea->title}}</a></p>
@endforeach