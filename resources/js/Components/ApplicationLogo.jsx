export default function ApplicationLogo(props) {
    const isProduction = process.env.NODE_ENV === 'production';
    const baseUrl = isProduction ? 'http://195.88.211.190/~sistemi4' : '';
    
    return (
        <div className="flex items-center" {...props}>
            <img 
                src={`${baseUrl}/assets/images/logosmk.png`}
                alt="SMK Sasmita Logo"
                className="h-20 w-auto"
            />
        </div>
    );
}
