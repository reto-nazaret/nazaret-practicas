#!/bin/bash

# Array of folder names
folders=('usuarios' 'idiomas' 'idioma_alumno' 'practicas' 'alumnos' 'profesores' 'ciclos' 'empresas' 'centros_trabajo' 'contactos')

# Function to create folders
create_folders() {
    for folder in "${folders[@]}"; do
        if [ ! -d "$folder" ]; then
            mkdir "$folder"
            echo "Folder '$folder' created."
        else
            echo "Folder '$folder' already exists."
        fi
    done
}

# Function to create files in folders
create_files() {
    for folder in "${folders[@]}"; do
        for method in 'get' 'post' 'put' 'delete'; do
            filename="${folder}_${method}.php"
            if [ ! -f "${folder}/${filename}" ]; then
                touch "${folder}/${filename}"
                echo "File '${filename}' created in folder '${folder}'."
            else
                echo "File '${filename}' already exists in folder '${folder}'."
            fi
        done
    done
}

# Call the function to create folders
create_folders

# Call the function to create files
create_files
