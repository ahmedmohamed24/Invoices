<!-- Footer opened -->
	<div class="main-footer ht-40">
		<div class="container-fluid pd-t-0-f ht-100p">
            all copy rights reserved
		</div>
    </div>

<script>

    function markAllAsRead(){
        fetch('{{ route('notifications.readAll') }}')
        .then(response=>response.json())
        .then(data=>{
            if(data.status===200){
                $('.notification-label').addClass('text-muted');
            }
        })
    }
</script>

