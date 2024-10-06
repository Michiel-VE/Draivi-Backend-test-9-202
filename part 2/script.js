let pressed = false

function fetchData() {
    if (!pressed) {
        fetch('show.php', {
            method: "GET"
        }).then(response => {
            return response.json()
        }).then(data => {
            showData(data)
        })
        pressed = true
    }


}

function emptyData() {
    pressed = false
    document.getElementById('list').innerHTML = ""
}

function addAmount(number, element) {
    fetch('changeOrderAmount.php', {
        method: "POST",
        body: JSON.stringify({number}),
        headers: {
            'Content-Type': 'application/json'
        }
    }).then(response => response.json())
        .then(status => {
            if (status.success) {
                element.nextElementSibling.innerText = `${parseInt(element.nextElementSibling.textContent) +1}`
            } else {
                alert('error ' + status.message)
            }
        })
}

function clearAmount(number, element) {
fetch('clearOrderAmount.php', {
    method: "POST",
    body: JSON.stringify({number}),
    headers: {
        'Content-Type': 'application/json'
    }
}).then(response => response.json())
    .then(status => {
        if (status.success) {
            element.previousElementSibling.innerText = `0`
        } else {
            alert('error ' + status.message)
        }
    })
}

function showData(data) {
    document.getElementById('list').innerHTML = `
    <table>
        <thead>
        <th>Name</th>
        <th>Price</th>
        <th>Size</th>
    </thead>
    <tbody>
         ${data.map(item => `
           <tr>
               <td>${item.name}</td>
                <td>${item.price}</td>
                  <td>${item.bottleSize === "" ? "Unknown" : item.bottleSize}</td>
                <td>
                    <div>
                        <button onclick="addAmount(${item.number}, this)">Add</button>
                        <p id="orderAmount">${item.orderAmount}</p>
                        <button onclick="clearAmount(${item.number}, this)">Clear</button>
                    </div>
                </td>
            </tr>
    `).join('')}
    </tbody>
    </table>
    `

}
