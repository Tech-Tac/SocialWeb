<script defer>
	function sendComment(form, container) {
		let oldHTML = container.innerHTML;

		const rollback = function() {
			container.innerHTML = oldHTML;
			toast("An error occurred.", "danger");
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
				oldHTML = container.innerHTML;
				if (value) {
					container.innerHTML += value;
					form.reset();
					toast("Commented successfully!", "success");
					if (container.getElementsByClassName("empty-comments")[0]) {
						container.getElementsByClassName("empty-comments")[0].remove();
					}
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
