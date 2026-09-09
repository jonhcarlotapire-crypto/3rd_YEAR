<?php if (!empty($_SESSION['flash_error'])): ?>

    <div
        class="card flash-alert"
        style="
            margin-bottom:16px;
            border-left:4px solid #dc2626;
            padding:14px;
            transition: opacity 0.5s ease;
            opacity: 1;
        "
    >

        <strong style="color:#b91c1c;">
            Error:
        </strong>

        <?=htmlspecialchars($_SESSION['flash_error'])?>

    </div>

    <?php unset($_SESSION['flash_error']); ?>

<?php endif; ?>


<?php if (!empty($_SESSION['flash_success'])): ?>

    <div
        class="card flash-alert"
        style="
            margin-bottom:16px;
            border-left:4px solid #16a34a;
            padding:14px;
            transition: opacity 0.5s ease;
            opacity: 1;
        "
    >

        <strong style="color:#15803d;">
            Success:
        </strong>

        <?=htmlspecialchars($_SESSION['flash_success'])?>

    </div>

    <?php unset($_SESSION['flash_success']); ?>

<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for 4 seconds, then fade out and remove flash alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.flash-alert');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500); // Matches the 0.5s transition time
        });
    }, 4000); 
});
</script>