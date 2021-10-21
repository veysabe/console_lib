# PHP CLI Library
PHP Library that allows you to create your own console commands and set arbitrary logic for them.

## Installation
1. Copy this repository to an empty directory
2. Create an app file through which you will execute commands (**<file_name>.php**)
3. Write this line at the beginning of the file: ```include 'lib/load.php';```

## Usage
First, you need to register your command. To do this, you may run the following command in your terminal:
>php **<file_name>.php** register [name=**command_name**] [description=**Description**]

- **<file_name>.php** - your app file created during the second stage of installation
- **command_name** - name of your command
- **Description** - description of your command

After that, your command will be registered in the ```/lib/command_manifest.json``` file. Also, a class will be created in the ```lib/classes``` folder to control the logic of your command.
The name of the class corresponds to the name of the team.

The **launch** method is predefined in the class file.
The body of this method will be executed.
In the class, you have access to the command name (```$this->command```), options (```$this->arguments```) and parameters (```$this->parameters```)
Feel free to create your own methods :) Just don't delete launch method.

### Passing arguments and parameters
In order to pass an option to your function, when calling the command, write it as ```{option_name}```.
To pass parameters, write them as ```[parameter=value]```. A multiple value for the parameter is also accepted. To do this, write them in the form ```[parameter={value1,value2,value3}]```

For example:
```
php app.php command_name {option} [name=Name] [description={"Here is some description","Have fun"}] {option2}
```