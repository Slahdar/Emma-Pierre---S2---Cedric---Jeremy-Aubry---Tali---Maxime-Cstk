
document.getElementById('new-product-form').addEventListener('submit', function (e) {
    e.preventDefault();  // Prevent the form from submitting normally

    var formData = new FormData(this);

    fetch('/api/products', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            alert('Product created successfully!');
            console.log('Success:', data);
            loadProducts();
        })
        .catch((error) => {
            alert('An error occurred.');
            console.error('Error:', error);
        });


});


function loadProducts() {
    fetch('/api/products', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            var tableBody = document.getElementById('products-table').getElementsByTagName('tbody')[0];

            // Clear the table before populating it
            tableBody.innerHTML = '';

            data.forEach(product => {
                var newRow = tableBody.insertRow();
                var nameCell = newRow.insertCell(0);
                var priceCell = newRow.insertCell(1);
                var descriptionCell = newRow.insertCell(2);
                var quantityCell = newRow.insertCell(3);
                var editCell = newRow.insertCell(4);

                // Set the initial cell values
                nameCell.textContent = product.product_name;
                priceCell.textContent = product.price;
                descriptionCell.textContent = product.description;
                quantityCell.textContent = product.quantity;

                // Create the buttons for edit, cancel, and validate
                var editButton = document.createElement('button');
                editButton.textContent = 'Edit';

                var cancelButton = document.createElement('button');
                cancelButton.textContent = 'Cancel';

                var validateButton = document.createElement('button');
                validateButton.textContent = 'Validate';

                // Append the buttons to the edit cell
                editCell.appendChild(editButton);

                // Function to enable editing for a row
                function enableEditRow(row) {
                    // Disable the edit button
                    editButton.disabled = true;

                    // Replace cell content with input fields
                    nameCell.innerHTML = '<input type="text" value="' + product.product_name + '">';
                    priceCell.innerHTML = '<input type="number" value="' + product.price + '">';
                    descriptionCell.innerHTML = '<input type="text" value="' + product.description + '">';
                    quantityCell.innerHTML = '<input type="number" value="' + product.quantity + '">';

                    // Replace the edit button with cancel and validate buttons
                    editCell.innerHTML = '';
                    editCell.appendChild(cancelButton);
                    editCell.appendChild(validateButton);

                    // Add event listeners for cancel and validate buttons
                    cancelButton.addEventListener('click', () => {
                        cancelEditRow(newRow, product);
                    });

                    validateButton.addEventListener('click', () => {
                        validateEditRow(newRow, product);
                    });
                }

                // Function to cancel editing for a row
                function cancelEditRow(row, originalProduct) {
                    // Reset cell content to original values
                    nameCell.textContent = originalProduct.product_name;
                    priceCell.textContent = originalProduct.price;
                    descriptionCell.textContent = originalProduct.description;
                    quantityCell.textContent = originalProduct.quantity;

                    // Reset the edit cell with the edit button
                    editCell.innerHTML = '';
                    editCell.appendChild(editButton);

                    // Reassign event listener for the edit button
                    editButton.disabled = false;
                    editButton.addEventListener('click', () => {
                        enableEditRow(newRow);
                    });
                }

                // Function to validate editing for a row
                function validateEditRow(row, originalProduct) {
                    // Get the new values from the input fields
                    var editedProduct = {
                        product_name: nameCell.querySelector('input').value,
                        price: priceCell.querySelector('input').value,
                        description: descriptionCell.querySelector('input').value,
                        quantity: quantityCell.querySelector('input').value,
                        id: originalProduct.id
                    };

                    // Perform the AJAX call or further processing with the edited product data
                    // ...

                    // For this example, log the edited product to the console
                    console.log('Edited Product:', editedProduct);

                    // Reset the edit cell with the edit button
                    editCell.innerHTML = '';
                    editCell.appendChild(editButton);
                }

                // Add event listener for the edit button
                editButton.addEventListener('click', () => {
                    enableEditRow(newRow);
                });
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}



window.onload = loadProducts;
