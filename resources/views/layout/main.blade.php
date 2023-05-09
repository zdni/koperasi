<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>KSU Abdi Karya</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/logo.ico') }}" type="image/x-icon"/>

	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{ asset('assets/css/fonts.min.css') }}"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.css') }}">
	<style>
		@media screen and (max-width: 576px) {
			.form-group > .text-right {
				text-align: left !important;
			}
		}
	</style>
</head>
<body>
	<div class="wrapper">
        @include('partials.header')
        @include('partials.sidebar')
		<div class="main-panel">
			<div class="container">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">{{ $page ?? 'Halaman' }}</h2>
								<h5 class="text-white op-7 mb-2">{{ $description ?? 'Deskripsi Halaman' }}</h5>
							</div>
							@yield('button-header')
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
                    @yield('content')
                </div>
			</div>
            @include('partials.footer')
		</div>
	</div>
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/dropzone/dropzone.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/fullcalendar/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/bootstrap-wizard/bootstrapwizard.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery.validate/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/summernote/summernote-bs4.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/select2/select2.full.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/owl-carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('assets/js/atlantis.min.js') }}"></script>
	<script>
		$('#table-account').DataTable({
			"pageLength": 5,
		});
		$('#table-employee').DataTable({
			"pageLength": 5,
		});
		$('#table-position').DataTable({
			"pageLength": 5,
		});
		$('#table-region').DataTable({
			"pageLength": 5,
		});
		$('#table-unit').DataTable({
			"pageLength": 5,
		});

		$('#period').datetimepicker({
			format: "MM-YYYY",
		});
		$('#period_').datetimepicker({
			format: "MM-YYYY",
		});

		$('#employee_id').select2({
			theme: "bootstrap"
		});
		$('#unit_id').select2({
			theme: "bootstrap"
		});
	</script>

	<script>
		$(document).ready(function() {
			const api = "{{ env('APP_URL') }}"
			
			function getAllLines() {
				const id = $('#id').val()

				if(id === undefined) return
	
				$.get(`${api}api/lines?account_id=${id}`, function(data, _status) {
					if(_status === 'success') {
						const tbodyAccount = $('#tbody-account')
						const {status, lines} = data
						
						if(status === 'success') {
							tbodyAccount.html('')

							lines.forEach(line => {
								tbodyAccount.append(`
									<tr>
										<td>${line.name}</td>
										<td>
											<div class="form-group">
												<div class="input-group">
													<div class="input-group-prepend">
														<div class="input-group-text">Rp</div>
													</div>
													<input type="hidden" class="form-control" value="${line.id}">
													<input type="number" class="form-control" value="${line.amount}">
													<div class="input-group-append">
														<button class="btn btn-sm btn-border btn-primary update-line"">
															<i class="fas fa-save"></i>
														</button>
														<button class="btn btn-sm btn-border btn-danger destroy-line">
															<i class="fas fa-trash"></i>
														</button>
													</div>
												</div>
											</div>
										</td>
									</tr>
								`)
							})

							$('.update-line').on('click', function(event) {
								const id = $(this).parent().siblings()[1].value
								const amount = $(this).parent().siblings()[2].value
								const user_id = $('#user_id').val()
								
								$.ajax({
									url: `${api}api/lines/${id}`,
									method: 'PUT',
									data: {
										amount,
										'user_id': user_id,
									}
								})
								.done(function(result) {
									const {status, message, line} = result
									let content = {
										'message': message,
										'title': 'Ubah Dana JHT'
									}
									
									let state = 'default'
									if(status === 'success') {
										state = 'success'
									}
									if(status === 'error') {
										state = 'warning'
									}

									$.notify(content,{
										type: state,
										placement: {
											from: 'top',
											align: 'right'
										},
										time: 1000,
										delay: 0,
									});
								})
								.fail(function(xhr, status, error) {
									console.log(xhr)
									console.log(status)
									console.log(error)
								});

								getAllLines()
							});
							$('.destroy-line').on('click', function(event) {
								const id = $(this).parent().siblings()[1].value
								const user_id = $('#user_id').val()
								
								$.ajax({
									url: `${api}api/lines/${id}`,
									type: 'DELETE',
									data: {
										'user_id': user_id,
									}
								})
								.done(function(result) {
									const {status, message, line} = result
									let content = {
										'message': message,
										'title': 'Hapus Dana JHT'
									}
									
									let state = 'default'
									if(status === 'success') {
										state = 'success'
									}
									if(status === 'error') {
										state = 'warning'
									}

									$.notify(content,{
										type: state,
										placement: {
											from: 'top',
											align: 'right'
										},
										time: 1000,
										delay: 0,
									});
								})
								.fail(function(xhr, status, error) {
									console.log(xhr)
									console.log(status)
									console.log(error)
								});
								
								getAllLines()
							});
						}
						$('#table-account-line').DataTable({
							"pageLength": 5,
							"ordering": false
						});
					}
				})
				return
			}
			getAllLines()

			function create() {
				const account_id = $('#id').val()
				const user_id = $('#user_id').val()
				
				const amount = $('#form-create-account-line #amount')
				const employee_id = $('#form-create-account-line #employee_id')

				const form = {
					'account_id': account_id,
					'amount': amount.val(),
					'employee_id': employee_id.val(),
					'state': 'draft',
					'user_id': user_id,
				}

				$.post(`${api}api/lines`, form, function(data, _status) {
					if(_status === 'success') {
						const {status, message, line} = data
						
						let content = {
							'message': message,
							'title': 'Tambah Dana JHT'
						}
						
						let state = 'default'
						if(status === 'success') {
							state = 'success'
						}
						if(status === 'error') {
							text = ''
							Object.entries(message).forEach(msg => {
								const [key, value] = msg
								text += ` ${value}`
							})
							
							content['message'] = text
							state = 'warning'
						}
						
						$.notify(content,{
							type: state,
							placement: {
								from: 'top',
								align: 'right'
							},
							time: 1000,
							delay: 0,
						});

						amount.val('')
						employee_id.val('').change()
					}
				})
				.done(function(msg){  })
				.fail(function(xhr, status, error) {
					console.log(xhr)
					console.log(status)
					console.log(error)
				});
				
				getAllLines()
			}

			$('#create-line').on('click', create );
		})
	</script>
</body>
</html>