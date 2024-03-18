
export function formatDate(dateTime) {
    const year = dateTime.getFullYear();
    const month = (dateTime.getMonth() + 1).toString().padStart(2, '0');
    const day = dateTime.getDate().toString().padStart(2, '0');
    const hours = dateTime.getHours().toString().padStart(2, '0');
    const minutes = dateTime.getMinutes().toString().padStart(2, '0');
    const seconds = dateTime.getSeconds().toString().padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}


export function calculateRemainingTime(openingTime) {
    const now = new Date();
    const openingDate = new Date(openingTime);
    const diff = openingDate.getTime() - now.getTime();

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

    let timeString = "";
    if (days > 0) {
      timeString += `${days} days, `;
    }
    if (hours > 0) {
      timeString += `${hours} hours, `;
    }
    if (minutes > 0) {
      timeString += `${minutes} minutes, `;
    }
    if (timeString.endsWith(", ")) {
      timeString = timeString.slice(0, -2);
    }

    return timeString;
  }

  export function isTimeRemaining(openingTime) {
    const now = new Date();
    const openingDate = new Date(openingTime);
    const diff = openingDate.getTime() - now.getTime();

    if(diff > 0){
      return true;
    }
    return false;
  }