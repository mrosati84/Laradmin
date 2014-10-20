<ul>
    @foreach($fieldValue as $relatedResult)
        <li>
            <a href="{{ route($prefix . '.' . strtolower($relationshipModel) . '.show', array('id' => $relatedResult['id'])) }}">{{ $relatedResult[$relationshipString] }}</a>
        </li>
    @endforeach
</ul>
