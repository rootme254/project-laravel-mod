<ul>
  @if( $user->agent )
    @foreach( $user->agent->listings as $listing )
    <li>{{$listing->title}}</li>
    @endforeach
  @endif
</ul>
