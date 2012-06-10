package br.com.celusatcrm.events
{
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	
	public class NacoesEventDispatcher extends EventDispatcher
	{
		
		public function NacoesEventDispatcher(target:IEventDispatcher=null)
		{
			//TODO: implement function
			super(target);
		}
		
		public static var Dispatcher:EventDispatcher = new EventDispatcher();

	}
}