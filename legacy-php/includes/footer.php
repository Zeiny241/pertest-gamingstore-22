</main>

<script>
    // Add simple interaction for deleting
    function confirmDelete(id) {
        if(confirm('Are you sure you want to delete this game?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
</script>
</body>
</html>
