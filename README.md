**Divisions**


**Required Endpoints**

<ul>
<li>[x] Register</li>
<li>[x] Login</li>
<li>[x] Get-Divisions
<li>[x] Generate-Divisions</li>
<li>[x] Check-Division</li>
</ul>




**Installation**

teniendo php y sqlite3 instalado:

php -S localhost:8000

**Endpoints**

**1. /register (POST)**

Registra un nuevo usuario en el sistema, validando la longitud del nombre de usuario y la contraseña.

*Body*

```
{
  "username": "nombre_de_usuario",
  "password": "contraseña"
}

```

*Validation Rules*
* El nombre de usuario debe tener entre 4 y 15 caracteres.
* La contraseña debe tener al menos 8 caracteres.

*Response*

```
{
  "message": "Usuario registrado satisfactoriamente"
}

```

*Error Response*

```
{
  "error": "El nombre de usuario debe tener entre 4 y 15 caracteres"
}

```

```
{
  "error": "La contraseña debe tener al menos 8 caracteres"
}

```

```
{
  "error": "Ese nombre de usuario ya existe"
}

```


**2. /login (POST)**

Permite que un usuario existente inicie sesión en el sistema verificando sus credenciales.

*Body*

```
{
  "username": "nombre_de_usuario",
  "password": "contraseña"
}


```

*Response*

```
{
  "message": "Inicio de sesión satisfactorio"
}

```

*Error Response*

```
{
  "error": "Credenciales inválidas"
}

```

**3. /get-divisions (POST)**

Obtiene todas las operaciones de división generadas para un usuario específico.

*Body*

```
{
  "username": "nombre_de_usuario"
}

```

*Response*

```
[
  {
    "id": 1,
    "divisor": 4,
    "dividend": 20,
    "user_id": 2,
    "is_solved": 0
  },
  ...
]


```

*Error Response*

```
{
  "error": "Usuario no encontrado"
}

```

**4. /generate-divisions (POST)**

Genera operaciones de división para un usuario específico. Si el usuario ya tiene operaciones, las elimina antes de crear nuevas.

Genera divisiones con las siguientes características:

* Dividendos de entre 1 y 99
* Divisores de entre 2 y 9
* Todas las divisiones tienen módulo de 0

*Body*

```
{
  "username": "nombre_de_usuario"
}

```

*Response*

```
{
  "message": "Operaciones generadas"
}

```

*Error Response*

```
{
  "error": "Usuario no encontrado"
}

```

**5. /check-divisions (POST)**

Verifica el resultado de una operación de división específica. Si el resultado es correcto, marca la operación como resuelta.


*Body*

```
{
  "operation_id": 1,
  "result": 5
}

```

*Response*

```
{
  "message": "Resultado Correcto!"
}

```

*Error Response*

```
{
  "error": "Resultado incorrecto."
}

```

```
{
  "error": "Operación no encontrada"
}

```