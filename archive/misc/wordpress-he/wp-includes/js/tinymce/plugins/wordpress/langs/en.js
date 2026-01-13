// EN lang variables

if (navigator.userAgent.indexOf('Mac OS') != -1) {
// Mac OS browsers use Ctrl to hit accesskeys
	var metaKey = 'Ctrl';
}
else {
	var metaKey = 'Alt';
}

tinyMCE.addToLang('',{
wordpress_more_button : '‫לפצל את הפוסט לעמוד פנימי עם התג More‏ (Alt+t)‬',
wordpress_page_button : '‫לפצל את הפוסט לעמוד חדש עם התג Page‬',
wordpress_more_alt : 'More...',
wordpress_page_alt : '...page...'
});
