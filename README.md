# COSECA AIS

<h4>Sistema para la Gestión y Control del seguiento del Servicio Comunitario en el Área de Ingeniería de Sistemas UNERG. </h4>


## Instalación

1. Lo primero sera instalar **DDEV** como plataforma para el entorno de desarrollo. DDEV se basa en Docker y si aun no lo tienes instalado consulta: [DDEV DOCS](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) para instalarlo en el sistema operativo que estes usando.
<br>
2. **COSECA AIS** tiene configurado los contenedores para la ejecucion del proyecto, asi que luego de instalar DDEV basta con correr el siguiente comando para levantar el servidor de desarrollo en tu computador.<br>

    ```bash
    ddev start
    ```
3. Con esto ya tendremos corriendo el servidor de desarrollo de la aplicación, sin embargo debemos configurar algunas cosas antes de continuar.

   3.1 Configurar los **assets** de nuestra aplicación correctamente, para ello ejecutamos:
    <br>
    ```bash
    bin/cake cakelte install
    ```
    <br>

    3.2 Configurar **Migraciones y BasicSeeds**

    ```bash
    ddev exec bin/cake migrations migrate
    composer reset-factory-faker
    ```
    <br>
4. Podrás acceder a la url generada despues de ejecutar **ddev start** para iniciar sesion

<br>

Con esto seria suficiente para ejecutar **COSECA AIS** en tu computador.

**Y buen código!** :coffee:
