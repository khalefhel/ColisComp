import emailjs from "emailjs-com";

const Contact = () => {
  const onSubmit = (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const templateParams = {
      name: formData.get("name"),
      email: formData.get("email"),
      phone: formData.get("phone"),
      subject: formData.get("subject"),
      message: formData.get("message"),
    };

    emailjs
      .send(
        "YOUR_SERVICE_ID",
        "YOUR_TEMPLATE_ID",
        templateParams,
        "YOUR_USER_ID"
      )
      .then((response) => {
        console.log("Email successfully sent!", response.status, response.text);
        alert("😀 Merci pour votre message, il sera traité au plus vite 😀");
        event.target.reset();
      })
      .catch((error) => {
        console.error("Email sending failed:", error);
        alert(
          "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer plus tard."
        );
      });
  };

  return (
    <div>
      <h1>Formulaire de Contact</h1>
      <form onSubmit={onSubmit}>
        <label htmlFor="name">Nom et Prénom:</label>
        <input type="text" id="name" name="name" required />

        <label htmlFor="email">Adresse mail:</label>
        <input type="email" id="email" name="email" required />

        <label htmlFor="phone">N° Téléphone:</label>
        <input type="text" id="phone" name="phone" required />

        <label htmlFor="subject">Sujet:</label>
        <select id="subject" name="subject">
          <option value="Devis">Devis</option>
          <option value="Questions">Questions</option>
          <option value="Autre">Autre</option>
        </select>

        <label htmlFor="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <label htmlFor="checkbox">
          <input type="checkbox" />
          En cochant cette case, j'accepte de recevoir des informations sur les
          différentes offres disponibles.
        </label>

        <button type="submit">Envoyer</button>
      </form>
    </div>
  );
};

export default Contact;
