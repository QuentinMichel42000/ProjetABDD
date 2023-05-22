function imprimerJeux() {
    const listeJeux = document.getElementById('ImpressionJeu');
    const contenuPage = document.body.innerHTML;

    document.body.innerHTML = listeJeux.innerHTML;
    window.print();

    // Restaurer le contenu de la page
    document.body.innerHTML = contenuPage;
}
s