@extends('_layouts.layout')

@section('content')
<div class="container-book">
    <h1>Libro {{$book['title']}}</h1>

    <div id="wrapper">
        <table align='center' cellspacing=2 cellpadding=5 id="data_table" border=1>
            <thead>
                <tr>
                    <th>Autores</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($book['authors'] as $author)
                <tr id="row{{ $author['id'] }}">
                    <td id="title_row{{ $author['id'] }}">{{ $author['name'] }}</td>
                    <td>
                        <input type="button" value="Eliminar" class="delete"
                            onclick="delete_author({{ $author['id'] }})">
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="text" id="new_author" placeholder="Id autor"></td>
                    <td><input type="button" class="add" onclick="add_author();" value="Añadir Autor"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

<script>
    // Add author
async function add_author() {
    const author_id = parseInt(document.getElementById('new_author').value);
    const book_id = {{ $book['id'] }}; 

    const response = await fetch(`/api/book/add-author/${book_id}/${author_id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    });

    if (response.ok) {
        window.location.reload();
    } else {
        alert('Error al agregar el autor');
    }
}

async function delete_author(author_id) {
    if (!confirm('¿Seguro que deseas eliminar este autor del libro?')) return;

    const book_id = {{ $book['id'] }}; 

    const response = await fetch(`/api/book/remove-author/${book_id}/${author_id}`, {
        method: 'POST'
    });

    if (response.ok) {
        document.getElementById(`row${author_id}`).remove();
    } else {
        alert('Error al eliminar el autor');
    }
}
</script>