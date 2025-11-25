document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.getElementById("openChatbot");
    const closeBtn = document.getElementById("closeChatbot");
    const chatbot = document.getElementById("chatbotWindow");
    const sendBtn = document.getElementById("sendMessage");
    const userInput = document.getElementById("userInput");
    const chatBody = document.getElementById("chatbotBody");

    // ===========================
    // 🎬 ABRIR Y CERRAR EL CHAT
    // ===========================
    openBtn.addEventListener("click", () => {
        chatbot.style.display = "flex";
        chatbot.classList.add("visible");
        chatBody.scrollTop = chatBody.scrollHeight;
    });

    closeBtn.addEventListener("click", () => {
        chatbot.classList.remove("visible");
        setTimeout(() => (chatbot.style.display = "none"), 200);
    });

    // ===========================
    // ✉️ EVENTOS DE MENSAJE
    // ===========================
    sendBtn.addEventListener("click", sendMessage);
    userInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") sendMessage();
    });
    setTimeout(showQuickOptions, 800);

    // ===========================
    // MEMORIA TEMPORAL Y DATOS REALES
    // ===========================
    let lastTopic = null;
    let userName = null;
    let academyData = {
        config: null,
        planes: [],
        disciplinas: []
    };

    // Cargar datos reales al iniciar
    fetch('/chatbot/data')
        .then(response => response.json())
        .then(data => {
            academyData = data;
            console.log("Datos del chatbot cargados:", academyData);
        })
        .catch(error => console.error("Error cargando datos del chatbot:", error));

    // ===========================
    // 💬 FUNCIONES DE MENSAJES
    // ===========================
    function appendMessage(sender, text) {
        const div = document.createElement("div");
        div.classList.add(sender === "bot" ? "bot-message" : "user-message");
        div.innerHTML = text;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
        return div;
    }

    // ===========================
    // 🚀 ENVIAR MENSAJE DEL USUARIO
    // ===========================
    function sendMessage() {
        const msg = userInput.value.trim();
        if (msg === "") return;

        appendMessage("user", msg);
        userInput.value = "";

        simulateThinking(msg);
    }

    // ===========================
    // 🧩 BOT "PENSANDO"
    // ===========================
    function simulateThinking(message) {
        const thinking = document.createElement("div");
        thinking.classList.add("bot-message", "thinking");
        thinking.innerHTML =
            `<i class="fas fa-robot me-2"></i> JeffBot está escribiendo<span class="dots">...</span>`;
        chatBody.appendChild(thinking);
        chatBody.scrollTop = chatBody.scrollHeight;

        setTimeout(() => {
            thinking.remove();
            const reply = getSmartReply(message);
            typeReply(reply);
        }, 1000 + Math.random() * 800);
    }

    // ===========================
    // ✍️ EFECTO DE ESCRITURA
    // ===========================
    function typeReply(text) {
        const div = appendMessage("bot", "");
        let i = 0;
        const speed = 15;

        function typing() {
            if (i < text.length) {
                div.innerHTML = text.slice(0, i + 1);
                chatBody.scrollTop = chatBody.scrollHeight;
                i++;
                setTimeout(typing, speed);
            } else {
                showQuickOptions();
            }
        }
        typing();
    }

    // ===========================
    // ⚡ OPCIONES RÁPIDAS
    // ===========================
    function showQuickOptions() {
        const existing = document.querySelector(".quick-options");
        if (existing) existing.remove();

        const options = [
            { icon: "fa-clock", text: "Horarios", value: "horarios" },
            { icon: "fa-sack-dollar", text: "Planes y precios", value: "precios" },
            { icon: "fa-running", text: "Disciplinas", value: "disciplinas" },
            { icon: "fa-futbol", text: "Entrenadores", value: "entrenadores" },
            { icon: "fa-map-marker-alt", text: "Ubicación", value: "ubicacion" },
            { icon: "fa-phone", text: "Contacto", value: "contacto" },
        ];

        const container = document.createElement("div");
        container.classList.add("quick-options");

        options.forEach((opt) => {
            const btn = document.createElement("button");
            btn.classList.add("quick-option-btn");
            btn.innerHTML = `<i class="fas ${opt.icon} me-1"></i> ${opt.text}`;
            btn.addEventListener("click", () => {
                appendMessage("user", `<i class="fas ${opt.icon} me-1"></i> ${opt.text}`);
                simulateThinking(opt.value);
                container.remove();
            });
            container.appendChild(btn);
        });

        chatBody.appendChild(container);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // ===========================
    // 🧠 RESPUESTAS INTELIGENTES (CON DATOS REALES)
    // ===========================
    function getSmartReply(text) {
        const msg = text.toLowerCase().trim();
        const config = academyData.config || {};

        // Si pregunta su nombre
        if (!userName && (msg.includes("me llamo") || msg.includes("soy "))) {
            userName = msg.split(" ").slice(-1)[0];
            return `¡Encantado, <b>${userName}</b>! 😄 Qué gusto tenerte en Jeff Academy. ¿Deseas conocer los horarios o los planes?`;
        }

        // Si ya tenemos nombre
        if (msg.includes("gracias") || msg.includes("thank")) {
            return `De nada${userName ? ", " + userName : ""}! 💪 Estoy para ayudarte.`;
        }

        if (msg.includes("horario") || msg.includes("hora")) {
            lastTopic = "horarios";
            const horarioSemana = config.horario_semana || "8:00 a.m. - 6:00 p.m.";
            const horarioSabado = config.horario_sabado || "8:00 a.m. - 6:00 p.m.";
            const horarioDomingo = config.horario_domingo || "Solo partidos y torneos";

            return `<i class="fas fa-clock text-primary me-1"></i> <b>Horarios:</b><br>🕗 Lunes a viernes: <b>${horarioSemana}</b><br>Sábados: <b>${horarioSabado}</b><br>Domingos: ${horarioDomingo} ⚽🔥`;
        }

        if (msg.includes("precio") || msg.includes("plan") || msg.includes("costo")) {
            lastTopic = "precios";
            let planesText = "";

            if (academyData.planes && academyData.planes.length > 0) {
                academyData.planes.forEach(plan => {
                    planesText += `<br>💰 <b>${plan.nombre}:</b> S/${parseInt(plan.precio)} (${plan.duracion} ${plan.duracion == 1 ? 'mes' : 'meses'})`;
                });
            } else {
                planesText = "<br>💰 <b>Mensual:</b> S/120<br>💪 <b>Trimestral:</b> S/320<br>🏆 <b>Anual:</b> S/1100";
            }

            return `<i class="fas fa-sack-dollar text-success me-1"></i> <b>Planes y precios:</b>${planesText}`;
        }

        if (msg.includes("disciplina") || msg.includes("deporte")) {
            lastTopic = "disciplinas";
            let discText = "";

            if (academyData.disciplinas && academyData.disciplinas.length > 0) {
                discText = "<br>⚽ <b>Nuestras Disciplinas:</b>";
                academyData.disciplinas.forEach(d => {
                    discText += `<br>🏅 <b>${d.nombre}:</b> ${d.edad_minima}-${d.edad_maxima} años`;
                });
            } else {
                discText = "<br>⚽ Fútbol formativo y competitivo para todas las edades.";
            }

            return `<i class="fas fa-running text-warning me-1"></i> <b>Disciplinas:</b>${discText}<br>¡Inscríbete en la que más te guste! 🏆`;
        }

        if (msg.includes("inscripción") || msg.includes("registrar")) {
            return `<i class="fas fa-clipboard-list text-warning me-1"></i> <b>Inscripciones:</b><br>📋 Puedes hacerlo en línea desde nuestra sección <b>Inscripción</b> o en la sede.<br>Recuerda traer tu <b>DNI</b> y ropa deportiva 👟.`;
        }

        if (msg.includes("entrenador") || msg.includes("coach")) {
            lastTopic = "entrenadores";
            return `<i class="fas fa-futbol text-info me-1"></i> <b>Entrenadores:</b><br>👨‍🏫 Tenemos entrenadores certificados con experiencia profesional. <br>Cada categoría tiene su propio coach especializado. ⚽💙`;
        }

        if (msg.includes("ubicacion") || msg.includes("donde") || msg.includes("lugar")) {
            lastTopic = "ubicacion";
            const direccion = config.direccion || "Av. América Sur, Trujillo – Frente al Mall Aventura";
            return `<i class="fas fa-map-marker-alt text-danger me-1"></i> <b>Ubicación:</b><br>📍 ${direccion}.`;
        }

        if (msg.includes("contacto") || msg.includes("whatsapp") || msg.includes("telefono")) {
            lastTopic = "contacto";
            const telefono = config.telefono || "+51 999 999 999";
            const email = config.email || "contacto@jeffacademy.pe";
            // Limpiar teléfono para link de whatsapp
            const whatsappNum = telefono.replace(/[^0-9]/g, '');

            return `<i class="fas fa-phone text-success me-1"></i> <b>Contacto:</b><br>📞 <b>${telefono}</b><br>📧 ${email}<br>O escríbenos por <a href="https://wa.me/${whatsappNum}" target="_blank" class="text-success"><b>WhatsApp</b></a> 💬`;
        }

        if (msg.includes("hola") || msg.includes("buenas") || msg.includes("saludos")) {
            return `¡Hola${userName ? ", " + userName : ""}! 😄<br>¿Deseas saber los <b>horarios</b>, <b>entrenadores</b> o <b>planes</b>?`;
        }

        if (msg.includes("adios") || msg.includes("chau")) {
            return `👋 ¡Hasta luego${userName ? ", " + userName : ""}!<br>Que tengas un excelente día.`;
        }

        // Si el mensaje no se entiende
        return `🤔 Hmmm... no tengo esa información aún. Pero puedo conectarte con un asesor por <a href="https://wa.me/51999999999" target="_blank" class="text-success"><b>WhatsApp</b></a> 💬`;
    }
});
