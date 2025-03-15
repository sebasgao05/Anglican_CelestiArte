document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.getElementById("registerForm");
    const userInfoSection = document.getElementById("userInfo");
    const userNameDisplay = document.getElementById("userName");
    const userEmailDisplay = document.getElementById("userEmail");
    const userRoleDisplay = document.getElementById("userRole");
    const logoutBtn = document.getElementById("logoutBtn");

    const adminPanel = document.getElementById("adminPanel");
    const userTable = document.getElementById("userTable");
    const prevPageBtn = document.getElementById("prevPage");
    const nextPageBtn = document.getElementById("nextPage");
    const currentPageSpan = document.getElementById("currentPage");
    let currentPage = 1;
    let totalPages = 1;

    registerForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(registerForm);

        fetch("register.php", { method: "POST", body: formData })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarPerfil(data.usuario.nombre, data.usuario.email, data.usuario.rol);
                if (data.usuario.rol === "Administrador") {
                    cargarUsuarios();
                }
            } else {
                alert(data.message);
            }
        });
    });

    function mostrarPerfil(nombre, email, rol) {
        userInfoSection.style.display = "block";
        userNameDisplay.textContent = nombre;
        userEmailDisplay.textContent = email;
        userRoleDisplay.textContent = rol;

        if (rol === "Administrador") {
            adminPanel.style.display = "block";
            cargarUsuarios();
        }
    }

    function cargarUsuarios(page = 1) {
        fetch(`get_users.php?page=${page}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                userTable.innerHTML = "";
                data.users.forEach(user => {
                    let row = `<tr>
                        <td>${user.nombre}</td>
                        <td>${user.email}</td>
                        <td>${user.rol}</td>
                    </tr>`;
                    userTable.innerHTML += row;
                });
                currentPage = data.currentPage;
                totalPages = data.totalPages;
                currentPageSpan.textContent = `Página ${currentPage} de ${totalPages}`;
                prevPageBtn.disabled = currentPage === 1;
                nextPageBtn.disabled = currentPage === totalPages;
            }
        });
    }

    prevPageBtn.addEventListener("click", () => {
        if (currentPage > 1) cargarUsuarios(currentPage - 1);
    });

    nextPageBtn.addEventListener("click", () => {
        if (currentPage < totalPages) cargarUsuarios(currentPage + 1);
    });

    logoutBtn.addEventListener("click", function () {
        fetch("logout.php", { method: "POST" }).then(() => location.reload());
    });
});
