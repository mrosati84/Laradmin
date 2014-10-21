<a href="{{ route($prefix . '.' . strtolower($relationshipModel) . '.show', array('id' => $fieldValue['id'])) }}">
    {{ $fieldValue[$relationshipString] }}
</a>