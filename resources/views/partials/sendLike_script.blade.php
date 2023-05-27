<script defer>
	function sendLike(model, id, button) {
		const oldNum = parseInt(button.getElementsByClassName('like-count')[0].textContent);
		button.getElementsByClassName('like-count')[0].textContent = button.classList.contains("btn-success") ? oldNum - 1 : oldNum + 1;
		button.classList.toggle("btn-outline-success");
		button.classList.toggle("btn-success");
		const rollback = function() {
			button.getElementsByClassName('like-count')[0].textContent = oldNum;
			button.classList.toggle("btn-outline-success");
			button.classList.toggle("btn-success");
		};
		const request = fetch(`${location.protocol}//${location.host}/${model}/${id}/like`, {
			method: "POST",
			headers: {
				x_csrf_token: document
					.querySelector('meta[name="csrf-token"]')
					.getAttribute("content"),
			},
		}).then((response) => {
			response.text().then((value) => {
				if (isNaN(parseInt(value))) {
					rollback();
				} else {
					button.getElementsByClassName('like-count')[0].textContent = parseInt(value);
				}
			});
		}).catch((err) => {
			rollback();
			console.error(err);
		});
	}
</script>
