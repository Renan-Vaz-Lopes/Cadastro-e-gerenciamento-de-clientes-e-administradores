function deletar_adm(id) {
    if (confirm("Tem certeza que quer deletar administrador?")) {
        window.location.replace("deletar-adm.php?id="+id+"")
    }
    
}

function deletar_cli(id) {
    if (confirm("Tem certeza que quer deletar cliente?")) {
        window.location.replace("deletar-cli.php?id="+id+"")
    }
    
}