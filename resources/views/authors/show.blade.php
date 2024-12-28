@extends('_layouts.layout')

@section('content')
<div class="container-author">
    <h1>{{$author['name']}}</h1>

    <div id="wrapper">
        <table align='center' cellspacing=2 cellpadding=5 id="data_table" border=1>
            <thead>
                <tr>
                    <th>Libros</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($author['books'] as $book)
                <tr id="row{{ $book['id'] }}">
                    <td id="title_row{{ $book['id'] }}">{{ $book['title'] }}</td>
                    <td>
                        <input type="button" value="Eliminar" class="delete" onclick="delete_book({{ $book['id'] }})">
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="text" id="new_book" placeholder="Id Libro"></td>
                    <td><input type="button" class="add" onclick="add_book();" value="Añadir Libro"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

<script>
    // Add book
    async function add_book() {
        const book_id = parseInt(document.getElementById('new_book').value);
        const auhtor_id = {{ $author['id'] }}; 

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

    async function delete_author(book_id) {
        if (!confirm('¿Seguro que deseas eliminar este autor del libro?')) return;

        const auhtor_id = {{ $author['id'] }}; 

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