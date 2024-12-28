@extends('_layouts.layout')

@section('content')
<div class="container-author">
    <h1>Lista de Autores</h1>

    <div id="wrapper">
        <table align='center' cellspacing=2 cellpadding=5 id="data_table" border=1>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de nacimiento</th>
                    <th>Fecha de Fallecimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($authors as $author)
                <tr id="row{{ $author['id'] }}">
                    <td id="name_row{{ $author['id'] }}">{{ $author['name'] }}</td>
                    <td id="b_date_row{{ $author['id'] }}">{{ $author['birth_date'] }}</td>
                    <td id="d_date_row{{ $author['id'] }}">{{ $author['death_date'] }}</td>
                    <td>
                        <input type="button" id="edit_button{{ $author['id'] }}" value="Editar" class="edit"
                            onclick="edit_row({{ $author['id'] }})">
                        <input type="button" id="save_button{{ $author['id'] }}" value="Guardar" class="save"
                            onclick="save_row({{ $author['id'] }})" style="display: none;">
                        <input type="button" value="Eliminar" class="delete" onclick="delete_row({{ $author['id'] }})">
                        <input type="button" value="Ver Detalles"
                            onclick="redirectToAuthorDetails({{ $author['id'] }})">

                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><input type="text" id="new_title" placeholder="Nombre"></td>
                    <td><input type="date" id="new_b_date"></td>
                    <td><input type="date" id="new_d_date"></td>
                    <td><input type="button" class="add" onclick="add_row();" value="Nuevo Autor"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

<script>
    // Activate edit mode
    function edit_row(id) {
        const nameCell = document.getElementById(`name_row${id}`);
        const birthDateCell = document.getElementById(`b_date_row${id}`);
        const deathDateCell = document.getElementById(`d_date_row${id}`);

        const originalName = nameCell.innerHTML;
        const originalBirthDate = birthDateCell.innerHTML;
        const originalDeathDate = deathDateCell.innerHTML;

        nameCell.innerHTML = `<input type="text" id="edit_name${id}" value="${originalName}">`;
        birthDateCell.innerHTML = `<input type="date" id="edit_b_date${id}" value="${originalBirthDate}">`;
        deathDateCell.innerHTML = `<input type="date" id="edit_d_date${id}" value="${originalDeathDate}">`;

        document.getElementById(`edit_button${id}`).style.display = 'none';
        document.getElementById(`save_button${id}`).style.display = 'inline-block';
    }

    // Save edit changes
    async function save_row(id) {
        const name = document.getElementById(`edit_name${id}`).value;
        const birthDate = document.getElementById(`edit_b_date${id}`).value;
        const deathDate = document.getElementById(`edit_d_date${id}`).value;

        const response = await fetch(`/api/author/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                birth_date: birthDate,
                death_date: deathDate
            })
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('Error al guardar los cambios');
        }
    }

    // Delete Author
    async function delete_row(id) {
        if (!confirm('¿Seguro que deseas eliminar este autor?')) return;

        const response = await fetch(`/api/author/${id}`, {
            method: 'DELETE'
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('Error al eliminar el autor');
        }
    }

    // Add new author
    async function add_row() {
        const name = document.getElementById('new_title').value;
        const birthDate = document.getElementById('new_b_date').value;
        const deathDate = document.getElementById('new_d_date').value;

        const response = await fetch('/api/author', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                birth_date: birthDate,
                death_date: deathDate
            })
        });

        if (response.ok) {
            window.location.reload();
        } else {
            alert('Error al agregar el autor');
        }
    }

    // Redirect to author details
    function redirectToAuthorDetails(author_id) {
        window.location.href = `/authors/show/${author_id}`;
    }
</script>