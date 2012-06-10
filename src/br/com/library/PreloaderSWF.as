package br.com.library
{
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.ProgressEvent;
	
	import mx.events.FlexEvent;
	import mx.events.RSLEvent;
	import mx.preloaders.DownloadProgressBar;
	
	/**
	 * This class extends the lightweight DownloadProgressBar class.  This class
	 * uses an embedded Flash 8 MovieClip symbol to show preloading.
	 * For handling both, SWF and RSL download, it separated its download progress
	 * by handling the appropriate events, i.e. RSLEvent
	 * 
	 * @author jessewarden
	 * @author Bernhard Hirschmann (http://coding.bhirschmann.de)
	 */    
	public class PreloaderSWF extends DownloadProgressBar
	{
		
		/**
		 * The Flash 8 MovieClip embedded as a Class.
		 */        
		[Embed(source="../assets/flash/preloader.swf", symbol="Preloader")]
		private var FlashPreloaderSymbol:Class;
		
		private var clip:MovieClip;
		
		private var    isRslDownloading:Boolean = false;
		
		private var rslPercent:Number = 0;
		private var swfPercent:Number = 0;
		
		private var rslBytesTotal:Number;
		private var rslBytesLoaded:Number = 0;
		
		private var swfBytesTotal:Number;
		private var swfBytesLoaded:Number = 0;
		
		public function PreloaderSWF()
		{
			super();
			
			// instantiate the Flash MovieClip, show it, and stop it.
			// Remember, AS2 is removed when you embed SWF's, 
			// even "stop();", so you have to call it manually if you embed.
			clip = new FlashPreloaderSymbol();
			addChild(clip);
			clip.gotoAndStop("start");
		}
		
		public override function set preloader(preloader:Sprite):void 
		{                   
			trace("starting...");
			
			// runtime shared library
			preloader.addEventListener( RSLEvent.RSL_PROGRESS, onRSLDownloadProgress );
			preloader.addEventListener( RSLEvent.RSL_COMPLETE, onRSLDownloadComplete );
			preloader.addEventListener( RSLEvent.RSL_ERROR, onRSLError );
			
			// application
			preloader.addEventListener( ProgressEvent.PROGRESS, onSWFDownloadProgress );    
			preloader.addEventListener( Event.COMPLETE, onSWFDownloadComplete );
			
			// initialization
			preloader.addEventListener( FlexEvent.INIT_PROGRESS, onFlexInitProgress );
			preloader.addEventListener( FlexEvent.INIT_COMPLETE, onFlexInitComplete );
			
			clip.preloader.rsl_amount_txt.text = clip.preloader.app_amount_txt.text = "0%";
			
			centerPreloader();
		}
		
		/**
		 * Makes sure that the preloader is centered in the center of the app.
		 * 
		 */        
		private function centerPreloader():void
		{
			x = (stageWidth / 2) - (clip.width / 2);
			y = (stageHeight / 2) - (clip.height / 2);
		}
		
		/**
		 * Updates the progress bar.
		 */
		private function updateProgress():void 
		{
			var p:Number = Math.round( (rslPercent + swfPercent) / 2 );
			clip.preloader.gotoAndStop(p);
		}
		
		/**
		 * As the RSL (runime shared library) (frame 2 usually) downloads, this event gets called.
		 * You can use the values from this event to update your preloader.
		 * @param event
		 * 
		 */        
		private function onRSLDownloadProgress( event:ProgressEvent ):void
		{
			isRslDownloading = true;
			
			rslBytesTotal = event.bytesTotal;
			rslBytesLoaded = event.bytesLoaded;
			rslPercent = Math.round( (rslBytesLoaded / rslBytesTotal) * 100);
			trace("onRSLDownloadProgress: rslBytesLoaded " + rslBytesLoaded);
			trace("onRSLDownloadProgress: rslBytesTotal " + rslBytesTotal);
			trace("onRSLDownloadProgress: " + rslPercent + "%");
			clip.preloader.rsl_amount_txt.text = String(rslPercent) + "%";
			
			updateProgress();
		}
		
		/**
		 * When the download of frame 2
		 * is complete, this event is called.  
		 * This is called before the initializing is done.
		 * @param event
		 * 
		 */        
		private function onRSLDownloadComplete( event:RSLEvent ):void
		{
			trace("onRSLDownloadComplete: 100% - bytes total: " + event.bytesTotal);
			clip.preloader.gotoAndStop(100);
			clip.preloader.rsl_amount_txt.text = "100%";
			rslPercent = 100;
		}
		
		private function onRSLError( event:RSLEvent ):void
		{
			trace("onRSLError: " + event.errorText + " - " + event.url);
			clip.preloader.status_txt.text = event.errorText;
		}
		
		/**
		 * As the SWF (frame 2 usually) downloads, this event gets called.
		 * You can use the values from this event to update your preloader.
		 * @param event
		 * 
		 */        
		private function onSWFDownloadProgress( event:ProgressEvent ):void
		{
			swfBytesTotal = event.bytesTotal;
			swfBytesLoaded = event.bytesLoaded;
			
			if ( isRslDownloading ) {
				// as soon as RSL starts downloading the SWF data are added by the RSL values
				swfBytesTotal -= rslBytesTotal;
				swfBytesLoaded -= rslBytesLoaded;
			}
			swfPercent = Math.round( (swfBytesLoaded / swfBytesTotal) * 100);
			trace("onSWFDownloadProgress: " + swfPercent + "%");
			trace("onSWFDownloadProgress: swfBytesLoaded " + swfBytesLoaded);
			trace("onSWFDownloadProgress: swfBytesTotal " + swfBytesTotal);
			clip.preloader.app_amount_txt.text = String(swfPercent) + "%";
			
			updateProgress();
		}
		
		/**
		 * When the download of frame 2
		 * is complete, this event is called.  
		 * This is called before the initializing is done.
		 * @param event
		 * 
		 */        
		private function onSWFDownloadComplete( event:Event ):void
		{
			trace("onSWFDownloadComplete: 100%");
			clip.preloader.gotoAndStop(100);
			clip.preloader.app_amount_txt.text = "100%";
			swfPercent = 100;
		}
		
		/**
		 * When Flex starts initilizating your application.
		 * @param event
		 * 
		 */        
		private function onFlexInitProgress( event:FlexEvent ):void
		{
			//trace("onFlexInitProgress: Initializing...");
			try {
				clip.preloader.gotoAndStop(100);
				clip.preloader.status_txt.text = "Initializing...";
			}
			catch (e:Error) {
			}
		}
		
		/**
		 * When Flex is done initializing, and ready to run your app,
		 * this function is called.
		 * 
		 * You're supposed to dispatch a complete event when you are done.
		 * I chose not to do this immediately, and instead fade out the 
		 * preloader in the MovieClip.  As soon as that is done,
		 * I then dispatch the event.  This gives time for the preloader
		 * to finish it's animation.
		 * @param event
		 * 
		 */        
		private function onFlexInitComplete( event:FlexEvent ):void 
		{
			trace("onFlexInitComplete");
			clip.addFrameScript(21, onDoneAnimating);
			clip.gotoAndPlay("fade out");
		}
		
		/**
		 * If the Flash MovieClip is done playing it's animation,
		 * I stop it and dispatch my event letting Flex know I'm done.
		 * @param event
		 * 
		 */        
		private function onDoneAnimating():void
		{
			trace("onDoneAnimating");
			clip.stop();
			dispatchEvent( new Event( Event.COMPLETE ) );
		}
		
	}
}