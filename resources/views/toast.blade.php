<script>

    setTimeout(() => {
        $.notify({
            title: '<strong>'+{!! json_encode($heading) !!}+'</strong>',
            icon: {!! json_encode($icon) !!},
            message:  '<br>'+{!! json_encode($msg) !!}
            },{
            element: 'body',
            type: {!! json_encode($type) !!},
            allow_dismiss: true,
            animate: {
                enter: 'animated fadeInUp',
                exit: 'animated fadeOutRight'
            },
            placement: {
                from: "bottom",
                align: "center"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
    
        });
    }, 1000);

</script>
