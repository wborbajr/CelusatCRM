package br.com.library
{
	import com.adobe.serialization.json.JSON;
	
	import flash.events.Event;
	import flash.events.HTTPStatusEvent;
	import flash.events.IEventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.URLLoader;
	import flash.net.URLLoaderDataFormat;
	import flash.net.URLRequest;
	import flash.net.URLRequestHeader;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	import flash.sampler.NewObjectSample;
	
	import mx.utils.OnDemandEventDispatcher;

	public class BackEndConnect
	{
		private var url:String;
		private var obj:Object = new Object();
		
		public function BackEndConnect(url:String, obj:Object) {
			this.url = url; 
			this.obj = obj;
		}
		
		public function Connect():void {
			var loader:URLLoader = new URLLoader();
			var header:URLRequestHeader = null;
			var requester:URLRequest = new URLRequest();
			
			header = new URLRequestHeader("pragma", "no-cache");
			
			requester.requestHeaders.push(header);
			requester.method = URLRequestMethod.POST;
			
			configureListeners(loader);
			
			loader.dataFormat = URLLoaderDataFormat.TEXT;
			
			// Modify to your needs
			requester.url = this.url; // "http://localhost:8085/MessageServer/servlet/MessageServlet";
			
//			var obj:Object = new Object();
//			obj.value1 = "Bob";
//			obj.value2 = "Sandy";
			
			var variables:URLVariables = new URLVariables();
			variables.myObject = JSON.encode(obj);
			requester.data = variables;
			
			loader.load(requester);
		}
		
		private function configureListeners(dispatcher:IEventDispatcher):void
		{
			dispatcher.addEventListener(Event.COMPLETE, completeHandler);
			dispatcher.addEventListener(Event.OPEN, openHandler);
			dispatcher.addEventListener(ProgressEvent.PROGRESS, progressHandler);
			dispatcher.addEventListener(SecurityErrorEvent.SECURITY_ERROR, securityErrorHandler);
			dispatcher.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpStatusHandler);
			dispatcher.addEventListener(IOErrorEvent.IO_ERROR, ioErrorHandler);
		}
		
		private function completeHandler(event:Event):void {
			try
			{
				var tempLoader:URLLoader = URLLoader(event.target);
				var obj:Object = JSON.decode(tempLoader.data);
				
				trace("completeHandler: " + tempLoader.data);
				trace(obj.value1);
				trace(obj.value2);
			}
			catch (error:Error)
			{
				trace("completeHandler: " + error.toString());
			}
		}
		
		private function openHandler(event:Event):void {
			trace("openHandler: " + event);
		}
		
		private function progressHandler(event:ProgressEvent):void {
			trace("progressHandler loaded:" + event.bytesLoaded + " total: " + event.bytesTotal);
		}
		
		private function securityErrorHandler(event:SecurityErrorEvent):void {
			trace("securityErrorHandler: " + event);
		}
		
		private function httpStatusHandler(event:HTTPStatusEvent):void {
			trace("httpStatusHandler: " + event);
		}
		
		private function ioErrorHandler(event:IOErrorEvent):void {
			trace("ioErrorHandler: " + event);
		}
		
	}
}