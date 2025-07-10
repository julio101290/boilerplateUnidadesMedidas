# CodeIgniter 4 Boilerplate Unidades de Medida

Boilerplate para catálogo de unidades de medida en CodeIgniter 4 con soporte para múltiples empresas. Compatible con PostgreSQL y MariaDB.

---

## 📦 Requisitos

- PHP >= 7.3
- CodeIgniter 4.x
- `julio101290/boilerplatelog`
- `julio101290/boilerplatecompanies`

---

## ⚙️ Instalación

### 1. Instalar por Composer

```bash
composer require julio101290/boilerplateunidadesmedidas
```

### 2. Ejecutar el comando de instalación

```bash
php spark boilerplateunidadesmedidas:installunidadesmedidas
```

Este comando:
- Copia las migraciones al proyecto.
- Ejecuta `php spark migrate`.
- Inserta datos iniciales con un seeder.

---

## 🧠 Ejemplo de uso en controlador

```php
$datos = $this->unidades_medida->mdlGetUnidades_medida($empresasID);

// Procesamiento personalizado sin Hermawan
helper('datatables');
$response = dataTablesServerSide($this->request, $datos, ['a.descripcion', 'b.nombre']);
return $this->response->setJSON($response);
```

---

## 📷 Capturas de pantalla

### Menú lateral

![Menú](https://github.com/user-attachments/assets/ae27afee-fe2d-4f28-9556-bde49f305105)

### Tabla CRUD

![CRUD](https://github.com/user-attachments/assets/357c23f7-a801-4ee9-8e96-6cd5ed4dcc3d)

---

## 📁 Estructura

- `src/Models/UnidadesMedidaModel.php`
- `src/Views/unidades_medida/index.php`
- `src/Database/Migrations/`
- `src/Database/Seeds/BoilerplateUnidadesMedida.php`
- `src/Commands/InstallCommandUnidadesMedidas.php`

---

## 🚀 Uso

Consulta los archivos fuente del controlador, modelo y vistas para adaptar este módulo a tu estructura.

---

## 📄 Licencia

MIT © [julio101290](mailto:juliocesar101290@hotmail.com)

---