<html>

@forelse($schoolRecords as $record)
    Nome da Disciplina: {{$record['discipline_name']}}
@empty
@endforelse
</html>
