<script defer>
	function comment(form, container) {
		const oldHTML = container.innerHTML;

		const rollback = function() {
			container.innerHTML = oldHTML;
			toast("An error occured.", "danger");
		};

		const request = fetch(`${location.protocol}//${location.host}/comments`, {
			method: "POST",
			headers: {
				x_csrf_token: document
					.querySelector('meta[name="csrf-token"]')
					.getAttribute("content"),
			},
			body: new FormData(form),
		}).then((response) => {
			response.text().then((value) => {
				if (value) {
					container.innerHTML += value;
					form.reset();
					toast("Commented successfully!", "success");
				} else {
					rollback();
				}
			});
		}).catch((err) => {
			rollback();
			console.error(err);
		});
	}
</script>
