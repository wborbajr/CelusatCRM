package br.com.celusatcrm.events
{
	import flash.events.Event;
	
	public class NacoesEvents extends Event
	{
		//*******************
		public static const LOGIN_VALID:String 	= "loginValid";
		public static const LOGOUT:String  		= "logout";
		public static const MAIN_SCREEN:String 	= "mainScreen";
		//**********************
		
		// Local object as option parameter
		private var _obj:Object;
		
		public function NacoesEvents(type:String, obj:Object = null, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			//TODO: implement function
			super(type, bubbles, cancelable);
		}
		
		// Override the inherited clone() method.
		override public function clone():Event {
			return new NacoesEvents(type, _obj);
		}
		
	}
}