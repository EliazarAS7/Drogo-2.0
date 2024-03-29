<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/lockers.css">
<?php 
if(isset($_SESSION['errores']) && count($_SESSION['errores']) > 0): ?>
    <div class='errors'>
        <?php foreach($_SESSION['errores'] as $error): ?>
            <p class='error'><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['errores']); // Elimina los mensajes de error de la sesión después de mostrarlos
endif; ?>
<!-- Formulario para la actualización de lockers -->
<?php if (isset($locker)): ?>
<form action="/actualizarLocker?locker=<?= htmlspecialchars($locker->refLocker); ?>"  method="POST" enctype="multipart/form-data" class="formu">
    <!-- Se imprimen los errores si los hay -->
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actLocker.php'; ?>
</form>
<?php endif; ?>
