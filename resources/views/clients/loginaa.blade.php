<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('clientsAssets/css/styles.css') }}">
</head>
<body>
    <div class="a4">
        <div class="green-bar"></div>
        <div class="content">
            <div class="header">
                <div class="logo">
                    <img src="https://lefaso.net/IMG/arton116672.jpg" alt="Logo Educo">
                </div>
                <div class="invoice-info">
                    <p><span class="highlight">DATE:</span> <span id="date"></span></p>
                    <p><span class="highlight">N°:</span> 12345</p>
                </div>
            </div>
            <h1 class="educo">BON DE COMMANDE</h1>
            <div class="contact-info">
                <div class="left-info">
                    <p class="bold">EDUCO</p>
                    <p class="bold">Bp: 3029 Ouaga 01</p>
                    <p class="bold">(+226) 25375188</p>
                    <p class="bold">Secteur 15 Ouaga 2000, Rue Nomba Mahamadi</p>
                    <p class="bold">RSI,DCI-OUAGA 6</p>
                    <label for="libele" class="bold">Libelé:</label>
                    <input type="text" id="libele" name="libele">
                </div>
                <div class="right-info">
                    <label for="fournisseur" class="bold"><span class="highlight">Fournisseur:</span></label>
                    <!-- Utiliser un champ de sélection ou d'entrée pour le fournisseur -->
                    <select id="fournisseur" name="fournisseur">
                        <option value="">Sélectionnez un fournisseur</option>
                        <option value="fournisseur1">Fournisseur 1</option>
                        <option value="fournisseur2">Fournisseur 2</option>
                        <!-- Ajoutez d'autres options selon vos besoins -->
                    </select>
                    <p class="bold">09 Bp 120 Ouagadougou 09</p>
                    <p class="bold">(+226) 25385353</p>
                    <p class="bold">Ouaga, pissy Sect26 Parcel20 lot2</p>
                    <p class="bold">IFU: 0020212A</p>
                    <p class="bold">RCCM: OUA 01001166G12345</p>
                    <p class="bold">RSI,DCI-OUAGA 6</p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>REFERENCE</th>
                        <th>DESIGNATION</th>
                        <th>PRIX</th>
                        <th>Qte</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody id="order-items">
                    <!-- Les lignes seront ajoutées dynamiquement ici -->
                </tbody>
            </table>
            <button onclick="addOrderItem()">Ajouter un article</button>
        </div>
    </div>
    <script>
        document.getElementById("date").textContent = new Date().toLocaleDateString();

        function addOrderItem() {
            const tbody = document.getElementById("order-items");
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td><input type="text" name="reference"></td>
                <td><input type="text" name="designation"></td>
                <td><input type="text" name="prix"></td>
                <td><input type="number" name="qte"></td>
                <td><input type="text" name="total"></td>
            `;
            tbody.appendChild(newRow);
        }
    </script>
</body>
</html>
