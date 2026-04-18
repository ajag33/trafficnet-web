<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trafficnet | Ingeniería y Telecomunicacionessss</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- React & Babel -->
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            scroll-behavior: smooth;
            background-color: #050a18;
        }
        .fade-in { animation: fadeIn 1s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .slider-zoom { animation: zoomIn 15s infinite alternate; }
        @keyframes zoomIn { from { transform: scale(1); } to { transform: scale(1.15); } }
        
        /* Efecto de scrollbar personalizado */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #050a18; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #2563eb; }
    </style>
</head>
<body class="text-white selection:bg-blue-600 selection:text-white">
    <div id="root"></div>

    <script type="text/babel">
        const { useState, useEffect } = React;

        // Diccionario de Iconos SVG incrustados para carga instantánea
        const Icons = {
            Network: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/>
                </svg>
            ),
            Cpu: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <rect x="4" y="4" width="16" height="16" rx="2"/><path d="M9 9h6v6H9z"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/>
                </svg>
            ),
            Video: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="m22 8-6 4 6 4V8Z"/><rect x="2" y="6" width="14" height="12" rx="2" ry="2"/>
                </svg>
            ),
            Wifi: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/>
                </svg>
            ),
            Zap: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                </svg>
            ),
            ShieldCheck: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>
                </svg>
            ),
            CheckCircle: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            ),
            ChevronRight: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            ),
            Menu: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            ),
            X: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            ),
            Phone: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            ),
            Mail: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/><rect x="2" y="5" width="20" height="14" rx="2"/>
                </svg>
            ),
            MapPin: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                </svg>
            ),
            Send: ({ size = 24, ...props }) => (
                <svg width={size} height={size} {...props} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            )
        };

        const App = () => {
            const [scrolled, setScrolled] = useState(false);
            const [currentSlide, setCurrentSlide] = useState(0);
            const [activeTab, setActiveTab] = useState(0);
            const [isMenuOpen, setIsMenuOpen] = useState(false);

            const slides = [
                {
                    title: "Soluciones de Telecomunicaciones",
                    highlight: "Empresariales",
                    description: "Especialistas en ingeniería de red y fibra óptica con más de 15 años transformando la infraestructura digital en Perú.",
                    // Imagen de servidor/red de alta fiabilidad
                    image: "https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&q=80&w=1920&ts=" + Date.now(),
                    tag: "Innovación en Conectividad"
                },
                {
                    title: "Seguridad Electrónica e",
                    highlight: "Inteligencia",
                    description: "Sistemas avanzados de videovigilancia IP y control de accesos para proteger sus activos más valiosos con tecnología 4K.",
                    image: "https://images.unsplash.com/photo-1557597774-9d2739f85a76?auto=format&fit=crop&q=80&w=1920&ts=" + Date.now(),
                    tag: "Protección Perimetral"
                },
                {
                    title: "Continuidad Eléctrica y",
                    highlight: "Respaldo",
                    description: "Sistemas de protección eléctrica, UPS y pozos a tierra certificados para garantizar la operatividad crítica 24/7.",
                    image: "https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=1920&ts=" + Date.now(),
                    tag: "Energía Ininterrumpida"
                }
            ];

            const services = [
                { title: "Cableado de Red", icon: "Network", desc: "Instalación de redes Cat 6, 6A y 7 certificadas para alta velocidad." },
                { title: "Fibra Óptica", icon: "Cpu", desc: "Tendido, fusión y certificación de enlaces de fibra monomodo y multimodo." },
                { title: "Sistemas CCTV", icon: "Video", desc: "Implementación de cámaras IP con analítica inteligente y monitoreo remoto." },
                { title: "Radio Enlaces", icon: "Wifi", desc: "Conexiones inalámbricas punto a punto para sedes de difícil acceso." },
                { title: "Protección Eléctrica", icon: "Zap", desc: "Sistemas de respaldo de energía y estabilización para equipos críticos." },
                { title: "Pozos a Tierra", icon: "ShieldCheck", desc: "Diseño y mantenimiento de puestas a tierra bajo normativa vigente." }
            ];

            const solutions = [
                {
                    id: 0,
                    title: "Infraestructura de Red",
                    subtitle: "Conectividad total",
                    desc: "Implementamos sistemas de cableado estructurado bajo estándares internacionales para corporativos y data centers.",
                    features: ["Certificación Fluke", "Ordenamiento de Racks", "Patch Panels", "Redes LAN/WAN"],
                    icon: "Network",
                    image: "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=1200&ts=" + Date.now()
                },
                {
                    id: 1,
                    title: "Seguridad Electrónica",
                    subtitle: "Monitoreo 24/7",
                    desc: "Protección inteligente mediante cámaras de seguridad y sistemas de control de acceso avanzados.",
                    features: ["Cámaras IP 4K", "Analítica de Video", "Control biométrico", "Alarmas"],
                    icon: "Video",
                    image: "https://images.unsplash.com/photo-1521791136064-7986c2923216?auto=format&fit=crop&q=80&w=1200&ts=" + Date.now()
                },
                {
                    id: 2,
                    title: "Energía & Respaldo",
                    subtitle: "Cero interrupciones",
                    desc: "Soluciones de protección eléctrica que aseguran que su negocio nunca se detenga ante fallas de energía.",
                    features: ["Sistemas UPS", "Bancos de Baterías", "Tableros Eléctricos", "Mantenimiento"],
                    icon: "Zap",
                    image: "https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&q=80&w=1200&ts=" + Date.now()
                }
            ];

            useEffect(() => {
                const handleScroll = () => setScrolled(window.scrollY > 50);
                window.addEventListener('scroll', handleScroll);
                const timer = setInterval(() => {
                    setCurrentSlide(prev => (prev === slides.length - 1 ? 0 : prev + 1));
                }, 7000);
                return () => {
                    window.removeEventListener('scroll', handleScroll);
                    clearInterval(timer);
                };
            }, [slides.length]);

            return (
                <div className="relative overflow-x-hidden min-h-screen bg-[#050a18]">
                    {/* Header */}
                    <nav className={`fixed w-full z-50 transition-all duration-500 ${scrolled ? 'bg-[#050a18]/90 backdrop-blur-md shadow-lg py-3' : 'bg-transparent py-6'}`}>
                        <div className="container mx-auto px-6 flex justify-between items-center">
                            <div className="flex items-center space-x-3">
                                <div className="bg-blue-600 p-2 rounded-lg transform rotate-45 shadow-lg shadow-blue-600/20">
                                    <div className="-rotate-45 text-white">
                                        <Icons.Network size={24} />
                                    </div>
                                </div>
                                <span className="text-2xl font-black tracking-tighter text-white">
                                    TRAFFIC<span className="text-blue-500">NET</span>
                                </span>
                            </div>

                            <div className="hidden lg:flex items-center space-x-10">
                                {['Inicio', 'Nosotros', 'Soluciones', 'Contacto'].map((item) => (
                                    <a key={item} href={`#${item.toLowerCase()}`} className="text-sm font-bold uppercase tracking-widest text-slate-300 hover:text-blue-500 transition-colors">
                                        {item}
                                    </a>
                                ))}
                                <button className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold text-sm uppercase tracking-widest transition-all shadow-lg shadow-blue-600/20">
                                    Cotizar
                                </button>
                            </div>

                            <button className="lg:hidden text-white" onClick={() => setIsMenuOpen(!isMenuOpen)}>
                                {isMenuOpen ? <Icons.X size={32} /> : <Icons.Menu size={32} />}
                            </button>
                        </div>
                        
                        {/* Menú Móvil */}
                        {isMenuOpen && (
                            <div className="lg:hidden bg-[#0a1122] absolute top-full left-0 w-full shadow-2xl p-6 flex flex-col space-y-4 border-t border-slate-800 animate-in slide-in-from-top">
                                {['Inicio', 'Nosotros', 'Soluciones', 'Contacto'].map((item) => (
                                    <a key={item} href={`#${item.toLowerCase()}`} onClick={() => setIsMenuOpen(false)} className="text-slate-200 font-bold uppercase text-sm tracking-widest hover:text-blue-500">{item}</a>
                                ))}
                            </div>
                        )}
                    </nav>

                    {/* Slider Principal */}
                    <section id="inicio" className="relative h-screen overflow-hidden">
                        {slides.map((slide, index) => (
                            <div key={index} className={`absolute inset-0 transition-opacity duration-1000 ease-in-out ${index === currentSlide ? 'opacity-100 z-10' : 'opacity-0 z-0'}`}>
                                <div className="absolute inset-0">
                                    <img 
                                        src={slide.image} 
                                        className={`w-full h-full object-cover ${index === currentSlide ? 'slider-zoom' : ''}`} 
                                        alt={slide.title}
                                        loading="eager"
                                        onError={(e) => e.target.style.display='none'}
                                    />
                                    <div className="absolute inset-0 bg-gradient-to-r from-[#050a18] via-[#050a18]/70 to-transparent"></div>
                                </div>
                                <div className="container mx-auto px-6 relative h-full flex items-center">
                                    <div className={`max-w-4xl transition-all duration-1000 ${index === currentSlide ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'}`}>
                                        <div className="inline-flex items-center space-x-2 bg-blue-600/20 border border-blue-600/30 px-4 py-2 rounded-full mb-8 backdrop-blur-sm">
                                            <span className="w-2 h-2 bg-blue-500 rounded-full animate-ping"></span>
                                            <span className="text-blue-400 text-xs font-black uppercase tracking-[0.2em]">{slide.tag}</span>
                                        </div>
                                        <h1 className="text-5xl md:text-8xl font-black text-white leading-[1.05] mb-8">
                                            {slide.title} <br />
                                            <span className="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">{slide.highlight}.</span>
                                        </h1>
                                        <p className="text-xl text-slate-400 mb-10 leading-relaxed max-w-2xl font-medium">{slide.description}</p>
                                        <div className="flex flex-col sm:flex-row gap-6">
                                            <a href="#soluciones" className="bg-blue-600 hover:bg-blue-700 text-white px-10 py-5 rounded-md font-black text-sm uppercase tracking-widest transition-all shadow-xl shadow-blue-600/20 text-center">Nuestras Soluciones</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </section>

                    {/* Sección: Lo que hacemos (Core de Negocio) */}
                    <section id="nosotros" className="py-32">
                        <div className="container mx-auto px-6 text-center">
                            <h2 className="text-blue-500 text-xs font-black uppercase tracking-[0.3em] mb-4">Lo que hacemos</h2>
                            <h3 className="text-4xl md:text-6xl font-black text-white mb-20 leading-tight">Infraestructura Crítica</h3>
                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-10 text-left">
                                {services.map((service, i) => {
                                    const IconComponent = Icons[service.icon];
                                    return (
                                        <div key={i} className="group p-10 bg-[#0d1526] border border-slate-800 rounded-2xl hover:border-blue-500 transition-all duration-500">
                                            <div className="w-16 h-16 bg-blue-600/10 text-blue-500 flex items-center justify-center mb-8 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                                <IconComponent size={32} />
                                            </div>
                                            <h4 className="text-2xl font-black mb-4 text-white group-hover:text-blue-500 transition-colors leading-tight">{service.title}</h4>
                                            <p className="text-slate-400 mb-8 font-medium leading-relaxed">{service.desc}</p>
                                            <a href="#" className="inline-flex items-center text-xs font-black uppercase tracking-widest text-blue-500 hover:text-white transition-colors">
                                                Saber más <Icons.ChevronRight size={16} className="ml-1" />
                                            </a>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </section>

                    {/* Sección: Soluciones (Pestañas - Dark Theme) */}
                    <section id="soluciones" className="py-32">
                        <div className="container mx-auto px-6 flex flex-col lg:flex-row gap-20">
                            <div className="lg:w-1/2">
                                <h2 className="text-blue-500 text-xs font-black uppercase tracking-[0.3em] mb-4">Ingeniería Especializada</h2>
                                <h3 className="text-4xl md:text-5xl font-black text-white mb-12 leading-tight">Soluciones que impulsan <br/>su conectividad.</h3>
                                <div className="space-y-4">
                                    {solutions.map((sol) => {
                                        const IconComponent = Icons[sol.icon];
                                        return (
                                            <button 
                                                key={sol.id} 
                                                onClick={() => setActiveTab(sol.id)} 
                                                className={`w-full flex items-center gap-6 p-8 rounded-2xl transition-all duration-300 text-left border ${activeTab === sol.id ? 'bg-blue-600 border-blue-600 text-white shadow-xl shadow-blue-600/20 scale-105' : 'bg-[#0d1526] border-slate-800 text-slate-300 hover:border-blue-900'}`}
                                            >
                                                <div className={`${activeTab === sol.id ? 'bg-white text-blue-600' : 'bg-blue-600/10 text-blue-500'} p-4 rounded-xl`}>
                                                    <IconComponent size={24} />
                                                </div>
                                                <div>
                                                    <h4 className="text-xl font-black mb-1">{sol.title}</h4>
                                                    <p className={`text-sm ${activeTab === sol.id ? 'text-blue-100' : 'text-slate-500'}`}>{sol.subtitle}</p>
                                                </div>
                                            </button>
                                        );
                                    })}
                                </div>
                            </div>
                            <div className="lg:w-1/2 relative bg-[#0d1526] rounded-[3rem] border border-slate-800 shadow-2xl overflow-hidden min-h-[500px]">
                                <img 
                                    src={solutions[activeTab].image} 
                                    className="absolute inset-0 w-full h-full object-cover opacity-50 transition-opacity duration-500" 
                                    alt={solutions[activeTab].title} 
                                    loading="lazy"
                                    onError={(e) => e.target.style.display='none'}
                                />
                                <div className="relative z-10 h-full flex flex-col justify-end p-12 bg-gradient-to-t from-[#0d1526] via-[#0d1526]/40 to-transparent">
                                    <h4 className="text-3xl font-black mb-4 text-white">{solutions[activeTab].title}</h4>
                                    <p className="text-slate-300 mb-8 leading-relaxed text-lg">{solutions[activeTab].desc}</p>
                                    <div className="grid grid-cols-2 gap-4">
                                        {solutions[activeTab].features.map((feat, i) => (
                                            <div key={i} className="flex items-center gap-3 text-sm font-bold text-slate-300">
                                                <Icons.CheckCircle size={18} className="text-blue-500" /> {feat}
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {/* Pie de página (Footer - Dark Theme) */}
                    <footer id="contacto" className="py-24 border-t border-slate-800">
                        <div className="container mx-auto px-6">
                            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
                                <div>
                                    <div className="flex items-center space-x-3 mb-8">
                                        <div className="bg-blue-600 p-1.5 rounded">
                                            <Icons.Network size={20} className="text-white" />
                                        </div>
                                        <span className="text-2xl font-black tracking-tighter text-white">
                                            TRAFFIC<span className="text-blue-500">NET</span>
                                        </span>
                                    </div>
                                    <p className="leading-relaxed text-slate-400">Soluciones integrales en telecomunicaciones, seguridad electrónica e ingeniería eléctrica para el mercado peruano.</p>
                                </div>
                                
                                <div>
                                    <h4 className="text-white font-black text-sm uppercase tracking-widest mb-8">Servicios</h4>
                                    <ul className="space-y-4 text-sm font-bold text-slate-400">
                                        <li><a href="#" className="hover:text-blue-500 transition-colors">Fibra Óptica</a></li>
                                        <li><a href="#" className="hover:text-blue-500 transition-colors">Cableado Estructurado</a></li>
                                        <li><a href="#" className="hover:text-blue-500 transition-colors">Videovigilancia</a></li>
                                        <li><a href="#" className="hover:text-blue-500 transition-colors">Pozos a Tierra</a></li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 className="text-white font-black text-sm uppercase tracking-widest mb-8">Contacto</h4>
                                    <ul className="space-y-6 text-sm font-medium text-slate-400">
                                        <li className="flex items-center gap-4">
                                            <Icons.Phone size={18} className="text-blue-500 shrink-0" />
                                            <span>+51 1 234 5678</span>
                                        </li>
                                        <li className="flex items-center gap-4">
                                            <Icons.Mail size={18} className="text-blue-500 shrink-0" />
                                            <span className="break-all">info@trafficnet.pe</span>
                                        </li>
                                        <li className="flex items-center gap-4">
                                            <Icons.MapPin size={18} className="text-blue-500 shrink-0" />
                                            <span>Lima, Perú</span>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <h4 className="text-white font-black text-sm uppercase tracking-widest mb-8">Novedades</h4>
                                    <p className="text-xs mb-6 text-slate-500">Suscríbete para recibir noticias técnicas.</p>
                                    <div className="flex items-stretch gap-2 h-10">
                                        <input type="email" placeholder="Email" className="bg-slate-900 border border-slate-800 rounded-lg px-4 py-2 w-full text-xs outline-none focus:border-blue-600 transition-all text-white" />
                                        <button className="bg-blue-600 px-3 rounded-lg text-white hover:bg-blue-700 transition-colors flex items-center justify-center shrink-0 shadow-lg shadow-blue-600/20">
                                            <Icons.Send size={16} />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div className="pt-10 border-t border-slate-800 text-center text-[10px] uppercase font-bold tracking-[0.2em] text-slate-600">
                                <p>© {new Date().getFullYear()} Trafficnet S.A.C. - Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </footer>
                </div>
            );
        };

        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);
    </script>
</body>
</html>
