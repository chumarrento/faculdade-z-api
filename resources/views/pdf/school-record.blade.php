<html>
    <body>
        <h1>Histórico</h1>
        <strong>Nome:</strong> {{$student->name}} <br>
        <strong>Matrícula:</strong> {{$student->registration}} <br>
        <strong>Curso:</strong> {{$student->course->name}} <br>
        <strong>Período:</strong> {{$student->current_semester}} <br>

        <hr>
        <table>
            <tr>
                <th>Nome da Disciplina</th>
                <th>Professor</th>
                <th>Status</th>
                <th>Nota final</th>
            </tr>
                @forelse($schoolRecords as $record)
                    <tr>
                        <td>{{$record['discipline_name']}}</td>
                        <td>{{$record['discipline_teacher']}}</td>
                        <td>{{$record['status']}}</td>
                        <td>{{$record['final_grade'] ?? '-'}}</td>
                    </tr>
                @empty
                    Nenhum dado encontrado.
                @endforelse
        </table>
    </body>
</html>
