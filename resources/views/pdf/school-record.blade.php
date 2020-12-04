<html>

@forelse($schoolRecord as $record)
    Nome da Disciplina: {{$record->discipline_name}}
@empty
@endforelse
</html>
