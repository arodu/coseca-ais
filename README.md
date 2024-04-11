# COSECA AIS

<h4>Sistema para la Gestión y Control del seguimiento del Servicio Comunitario en el Área de Ingeniería de Sistemas UNERG. </h4>


## 🚀 Instalación  

Necesitara:

- [PHP 8](https://www.php.net/).
- [DDEV](https://ddev.readthedocs.io/).
- [Docker](https://www.docker.com/get-started/).
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/).

1. Haga un [Fork](https://github.com/arodu/coseca-ais) de este repositorio y un clon en local:

```bash
git clone git@github.com:your_username/coseca-ais.git
```


2. Inicie [DDEV](https://ddev.readthedocs.io/) con:

```bash
ddev start
```
<br>

> [!IMPORTANT]  
> Ejecutar el comando **ddev start** en tu terminal desde la carpeta del proyecto.

<br>

3. Entrar en el contenedor con:

```bash
ddev ssh
```
4. Instalar **dependencias** con:
```bash
composer install
```
5. Configurar los **assets** de nuestro proyecto:
 ```bash
    bin/cake cakelte install
```
6. Configurar **Migraciones y BasicSeeds**:

```bash
ddev exec bin/cake migrations migrate
composer reset-factory-faker
```
<br>

> [!IMPORTANT]  
> Ejecutar los comandos **composer install**, **bin/cake cakelte install** y la configuración de **Migraciones y BasicSeeds** dentro del contenedor.

<br>

7. Podrás acceder a la url generada en tu terminal después de ejecutar **ddev start**.


Con esto seria suficiente para ejecutar **COSECA AIS** en tu computador.

**Y buen código!** ☕