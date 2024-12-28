@extends('_layouts.layout')

@section('content')
<div class="container-book">
    <h1>Lista de Libros</h1>

    <div id="wrapper">
        <table align='center' cellspacing=2 cellpadding=5 id="data_table" border=1>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Fecha de publicación</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr id="row{{ $book['id'] }}">
                    <td id="title_row{{ $book['id'] }}">{{ $book['title'] }}</td>
                    <td id="date_row{{ $book['id'] }}">{{ $book['published_date'] }}</td>
                    <td id="genre_row{{ $book['id'] }}">{{ $book['genre'] }}</td>
                    <td>
                        <input type="button" id="edit_button{{ $book['id'] }}" value="Editar" class="edit"
                            onclick="edit_row({{ $book['id'] }})">
                        <input type="button" id="save_button{{ $book['id'] }}" value="Guardar" class="save"
                            onclick="save_row({{ $book['id'] }})" style="display: none;">
                        <input type="button" value="Eliminar" class="delete" onclick="delete_row({{ $book['id'] }})">
                        <input type="button" value="Ver Detalles" onclick="redirectToBookDetails({{ $book['id'] }})">

                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="text" id="new_title" placeholder="Título"></td>
                    <td><input type="date" id="new_date"></td>
                    <td><input type="text" id="new_genre" placeholder="Género"></td>
                    <td><input type="button" class="add" onclick="add_row();" value="Nuevo Libro"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

<script>
    // Activate edit mode
    function edit_row(id) {
        const titleCell = document.getElementById(`title_row${id}`);
        const dateCell = document.getElementById(`date_row${id}`);
        const genreCell = document.getElementById(`genre_row${id}`);

        const originalTitle = titleCell.innerHTML;
        const originalDate = dateCell.innerHTML;
        const originalGenre = genreCell.innerHTML;

        titleCell.innerHTML = `<input type="text" id="edit_title${id}" value="${originalTitle}">`;
        dateCell.innerHTML = `<input type="date" id="edit_date${id}" value="${originalDate}">`;
        genreCell.innerHTML = `<input type="text" id="edit_genre${id}" value="${originalGenre}">`;

        document.getElementById(`edit_button${id}`).style.display = 'none';
        document.getElementById(`save_button${id}`).style.display = 'inline-block';
    }

    // Save edit changes
    async function save_row(id) {
        const title = document.getElementById(`edit_title${id}`).value;
        const date = document.getElementById(`edit_date${id}`).value;
        const genre = document.getElementById(`edit_genre${id}`).value;

        const response = await fetch(`/api/book/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                title: title,
                published_date: date,
                genre: genre
            })
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('Error al guardar los cambios');
        }
    }

    // Delete Book
    async function delete_row(id) {
        if (!confirm('¿Seguro que deseas eliminar este libro?')) return;

        const response = await fetch(`/api/book/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            document.getElementById(`row${id}`).remove();
        } else {
            alert('Error al eliminar el libro');
        }
    }

    // Add new book
    async function add_row() {
        const title = document.getElementById('new_title').value;
        const date = document.getElementById('new_date').value;
        const genre = document.getElementById('new_genre').value;

        const response = await fetch(`/api/book`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                title: title,
                published_date: date,
                genre: genre
            })
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('Error al agregar el libro');
        }
    }

    // Redirect to book details
    function redirectToBookDetails(book_id) {
        window.location.href = `/books/show/${book_id}`;
    }
</script>