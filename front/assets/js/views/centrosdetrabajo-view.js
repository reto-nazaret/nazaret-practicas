let data = [];

async function obtenerDatos() {
    
    return await customFetch("GET", "centros_trabajo")
        .then(datos => {
            data = datos;
            console.log(data);
            return data; 
        })
        .catch(error => console.error('Error:', error));
}
let boton = function(cell, formatterParams){ //plain text value
    return "<button type='submit' class='btn btn-primary'>Editar</button>";
};
let boton2 = function(cell, formatterParams){ //plain text value
    return "<button type='submit' class='btn btn-danger'>Eliminar</button>";
};

let selectedRowId = null;


function handleRowClick(e, row){
    selectedRowId = row.getData().id; 

    console.log("Selected Row ID:", selectedRowId);

    // Get the full pathname
    const pathname = window.location.pathname;

    // Split the pathname by '/'
    const pathSegments = pathname.split('/');

    // Get the first segment (excluding any empty segments)
    const firstSegment = pathSegments.find(segment => segment.trim() !== '');
console.log("First segment:", firstSegment);
    let filePath = `../../${firstSegment}/formularios/centrosDeTrabajo/edit_centrosDeTrabajo.html?id=${selectedRowId}`;    
    // let filePath = `/formularios/alumnos/edit_alumnos.html?id=${selectedRowId}`;    
console.log("filePath: ", filePath);
    let link = document.createElement('a');

    link.href = filePath;


    link.click();


}



obtenerDatos().then(() => {
    var table = new Tabulator("#example-table", {
        data: data.centros_trabajo,
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 10,
        paginationSizeSelector: [10, 25, 50],
        movableColumns: true,
        paginationCounter: "rows",
        columns: [
            { title: "", field: "id", width: 90 },
            { title: "Empresa", field: "empresa"},
            { title: "Denominacion", field: "denominacion"},
            { title: "Pais", field: "pais"},
            { title: "Territorio", field: "territorio"},
            { title: "Municipio", field: "municipio"},
            { title: "Codigo Postal", field: "codigo_postal"},
            { title: "Direccion", field: "direccion"},
            { title: "Telefono", field: "telefono"},
            { title: "FAX", field: "fax"},
            { title: "Mail", field: "mail"},
            { title: "Actividad", field: "actividad"},
            { title: "Numero Trabajadores", field: "numero_trabajadores"},
            { title: "", formatter: boton, hozAlign: "center", cellClick: handleRowClick},
            { title: "", formatter: boton2, hozAlign: "center"}

        ],
    });
});