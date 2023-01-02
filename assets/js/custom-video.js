const set_volume = (video, value) => {
	video.volume = value / 100;
}

const add_video_play_pause_listener = (video, timebar) => {
	video.addEventListener('click', () => {
		if (video.paused) {
			video.play();
			timebar.classList.remove('pause');
		} else {
			video.pause();
			timebar.classList.add('pause');			
		}
	});
};

const change_video = (message, video, source, timebar, volume_wrapper, show_timebar, show_volume ) => {
	// remove message and pause the video
	message.classList.add('deactivated');
	video.pause();


	// set the new video
	source.setAttribute('src', video.getAttribute('video-url'));
	source.setAttribute('type', 'video/webm');
	video.currentTime = 0;
	video.muted = false;
	video.load();

	if (show_timebar) {
		// update timebar to the duration of second video
		timebar.style.animationDuration = `${video.duration}s`;
		timebar.style.animationName = 'grow2';
	}

	// play second video
	video.onloadedmetadata = () => {
		video.play();

		if (show_timebar) {
			timebar.classList.add('animate');
		}

		if (show_volume) {
			volume_wrapper.classList.add('active');
		}
	};
};

const main = () => {
	const message = document.querySelector('#custom-video-popup');
	const video = document.querySelector('video#custom-video');
	const source = document.querySelector('#custom-video source');
	const timebar = document.querySelector('#timebar');
	const volume_wrapper = document.querySelector('#custom-video-volume-wrapper');
	const volume = document.querySelector('#custom-video-volume');
	const show_timebar = video.getAttribute('timebar');
	const show_volume = video.getAttribute('volume');

	console.log('timebar:', show_timebar);

	video.load();
	video.onloadedmetadata = () => {
		console.log('metadata loaded');
		timebar.style.animationDuration = `${video.duration}s`;

		console.log('animation duration', video.duration);
		if (show_timebar) {
			console.log('timebar', timebar);

			timebar.classList.add('animate');
		}
	};

	message.addEventListener('click', () => {
		change_video(message, video, source, timebar, volume_wrapper, show_timebar, show_volume);
		add_video_play_pause_listener(video, timebar);
	});

	volume.addEventListener('input', () => {
		set_volume(video, volume.value);
	});
}

document.addEventListener("DOMContentLoaded", main, false);