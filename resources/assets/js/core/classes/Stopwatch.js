'use strict'

class Stopwatch {
	constructor() {
		this.timer = 0
		this.elapsed = 0
	}

	/* Start a timer. */
	start() {
		this.timer = new Date().getTime()
	}

	/* Calculate how much time has elapsed since the timer started. */
	stop() {
		const currentTime = new Date().getTime()

		this.elapsed = Math.round( (currentTime - this.timer) / 1000 )

		this.timer = 0
	}

	// get elapsed() {
	// 	return this.elapsed
	// }
}

export default Stopwatch;